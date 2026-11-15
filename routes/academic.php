<?php

use App\Academic\ScenarioRunner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/dashboard'));
Route::get('/login', fn () => view('academic.login'))->name('login');
Route::post('/login', function (Request $request) {
    $data = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
    if (!Auth::attempt($data)) { return back()->withErrors(['email' => 'Credenciales de demostración incorrectas.']); }
    $request->session()->regenerate();
    return redirect('/dashboard');
});
Route::middleware(App\Academic\DemoAuthenticate::class)->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect('/login');
    });
    Route::get('/dashboard', fn () => view('academic.dashboard', ['counts' => collect(['customers', 'contracts', 'invoices', 'payments'])->mapWithKeys(fn ($table) => [$table => DB::table($table)->count()])->all()]));
    $tables = ['customers' => ['Clientes', ['id', 'first_name', 'last_name', 'identity_document', 'email']], 'contracts' => ['Contratos', ['id', 'customer_id', 'start_date', 'status', 'final_price']], 'invoices' => ['Recibos', ['id', 'invoice_number', 'contract_id', 'total_amount', 'status']], 'payments' => ['Pagos', ['id', 'invoice_id', 'amount', 'payment_method', 'status']]];
    foreach ($tables as $table => [$title, $columns]) {
        Route::get('/'.$table, fn () => view('academic.list', ['title' => $title, 'columns' => $columns, 'records' => DB::table($table)->select($columns)->orderBy('id')->get()]));
    }
    Route::get('/demo/yape', fn () => view('academic.yape', ['intents' => DB::table('yape_payment_intents')->orderBy('id')->get(), 'scenarios' => ScenarioRunner::SCENARIOS]));
    Route::post('/demo/yape', function (Request $request, ScenarioRunner $runner) {
        $data = $request->validate(['scenario' => 'required|in:'.implode(',', array_keys(ScenarioRunner::SCENARIOS))]);
        $result = $runner->run($data['scenario']);
        return redirect('/demo/yape')->with('result', $result->intent_number.': '.$result->status);
    });
});
