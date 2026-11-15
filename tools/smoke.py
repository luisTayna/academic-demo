"""Start one owned loopback-only PHP server, exercise demo HTTP, then stop it."""
from pathlib import Path
import argparse, subprocess, socket, time, urllib.request, urllib.error, urllib.parse
import http.cookiejar, re, sqlite3, json, os

ROOT=Path(__file__).resolve().parents[1]
assert ROOT.name=='academic-demo' and (ROOT/'ACADEMIC_DEMO_ONLY').read_text().strip()=='noretel-academic-only-v1'
parser=argparse.ArgumentParser();parser.add_argument('--php',default='php');args=parser.parse_args()
with socket.socket() as s:
    if s.connect_ex(('127.0.0.1',8091))==0:raise SystemExit('Port 8091 is already in use; no process was started or modified.')
log=ROOT/'storage/logs/smoke-server.log'
checks=[]
jar=http.cookiejar.CookieJar();client=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(jar))
def request(path, data=None, expected=200, host=None):
    headers={'Host':host} if host else {}
    req=urllib.request.Request('http://127.0.0.1:8091'+path,data=urllib.parse.urlencode(data).encode() if data is not None else None,headers=headers)
    try:r=client.open(req,timeout=10)
    except urllib.error.HTTPError as e:r=e
    body=r.read().decode('utf-8',errors='replace')
    assert r.status==expected,(path,r.status,expected)
    assert r.headers.get('X-Academic-Demo')=='isolated-v1','Unexpected server identity; refusing further requests.'
    return body
def csrf(body):
    match=re.search(r'name="_token"[^>]*value="([^"]+)"',body)
    assert match,'CSRF token missing'
    return match.group(1)
def state():
    file=ROOT/'database/academic.sqlite'
    with sqlite3.connect(file.as_uri()+'?mode=ro',uri=True) as db:
        return {'payments':db.execute('SELECT COUNT(*) FROM payments').fetchone()[0], 'invoices':dict(db.execute('SELECT id,status FROM invoices')), 'intents':dict(db.execute('SELECT intent_number,status FROM yape_payment_intents'))}
with log.open('wb') as output:
    process=subprocess.Popen([args.php,'-d','disable_functions=exec,shell_exec,system,passthru,popen,proc_open,fsockopen,pfsockopen,stream_socket_client,curl_exec,curl_multi_exec','-S','127.0.0.1:8091','-t','public','public/router.php'],cwd=ROOT,stdout=output,stderr=output,creationflags=subprocess.CREATE_NO_WINDOW if os.name=='nt' else 0)
    try:
        for attempt in range(40):
            if process.poll() is not None:raise RuntimeError('Owned demo server failed to start; consult its local log.')
            try:
                with socket.create_connection(('127.0.0.1',8091),timeout=.1):break
            except OSError:time.sleep(.1)
        page=request('/login');token=csrf(page);checks.append('login_page')
        request('/login',{'email':'evaluador@example.test','password':'DemoAcademica2026!'},419);checks.append('csrf_rejected')
        page=request('/login',{'_token':token,'email':'evaluador@example.test','password':'DemoAcademica2026!'})
        assert 'Datos ficticios' in page;checks.append('authenticated_dashboard')
        for path in ['/customers','/contracts','/invoices','/payments','/demo/yape']:
            request(path);checks.append(path)
        request('/network/routers/1/ssh',expected=404);request('/billing/openwa/webhook',{},404);request('/.env',expected=404);checks.append('unsafe_routes_absent')
        request('/dashboard',expected=403,host='outside.example');checks.append('nonlocal_host_rejected')
        page=request('/demo/yape');token=csrf(page)
        before=state()['payments']
        request('/demo/yape',{'_token':token,'scenario':'match'})
        first=state();assert first['invoices'][1]=='paid' and first['payments'] in [before,before+1]
        request('/demo/yape',{'_token':token,'scenario':'match'});assert state()['payments']==first['payments'];checks.append('real_match_and_idempotency')
        for name,status in [('amount_mismatch','observed'),('security_mismatch','observed'),('missing_receiver','waiting_receiver_event')]:
            request('/demo/yape',{'_token':token,'scenario':name})
            after=state();assert after['payments']==first['payments']
            number={'amount_mismatch':2,'security_mismatch':3,'missing_receiver':4}[name]
            assert after['intents']['DEMO-YAPE-'+str(number)]==status
            assert after['invoices'][number]=='pending'
            checks.append(name)
        request('/logout',{'_token':token});checks.append('logout')
        result={'status':'passed','checks':checks,'count':len(checks),'server_bind':'127.0.0.1:8091','state':state(),'owned_server_stopped':False}
    finally:
        process.terminate()
        try:process.wait(timeout=5)
        except subprocess.TimeoutExpired:process.kill();process.wait(timeout=5)
if 'result' in globals():
    result['owned_server_stopped']=process.poll() is not None
    (ROOT/'storage/logs/smoke-result.json').write_text(json.dumps(result,indent=2),encoding='utf-8')
    print(json.dumps(result,ensure_ascii=False))
