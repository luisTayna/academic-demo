"""Verify fail-closed entry points without opening any external database."""
from pathlib import Path
import argparse,os,subprocess,json
root=Path(__file__).resolve().parents[1]
p=argparse.ArgumentParser();p.add_argument('--php',default='php');args=p.parse_args()
cases=[('unsafe_command',['artisan','migrate:fresh'],{},2),('mysql_refused',['artisan','demo:verify'],{'DB_CONNECTION':'mysql'},255),('outside_database_refused',['artisan','demo:verify'],{'DB_DATABASE':str(root.parent/'forbidden.sqlite')},255),('production_refused',['artisan','demo:verify'],{'APP_ENV':'production'},255),('external_host_refused',['artisan','demo:verify'],{'DB_HOST':'outside.example'},255)]
for name,argv,overrides,expected in cases:
 env=os.environ.copy();env.update(overrides)
 result=subprocess.run([args.php,*argv],cwd=root,env=env,capture_output=True,text=True)
 assert result.returncode==expected,(name,result.returncode)
assert not (root.parent/'forbidden.sqlite').exists()
print(json.dumps({'fail_closed_checks':len(cases),'outside_database_created':False}))
