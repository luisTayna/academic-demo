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

    Route::get('/dashboard', function () {
        $counts = [
            'customers' => DB::table('customers')->count(),
            'contracts' => DB::table('contracts')->count(),
            'invoices'  => DB::table('invoices')->count(),
            'payments'  => DB::table('payments')->count(),
            'yape_validated' => DB::table('yape_payment_intents')->where('status', 'validated')->count(),
            'yape_observed'  => DB::table('yape_payment_intents')->where('status', 'observed')->count(),
            'yape_waiting'   => DB::table('yape_payment_intents')->where('status', 'waiting_receiver_event')->count(),
        ];
        return view('academic.dashboard', ['counts' => $counts]);
    });

    // Clientes (Diseño NoreTel Clientes)
    Route::get('/customers', function () {
        $customers = DB::table('customers')
            ->leftJoin('contracts', 'customers.id', '=', 'contracts.customer_id')
            ->leftJoin('invoices', 'contracts.id', '=', 'invoices.contract_id')
            ->select([
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'customers.identity_document',
                'customers.email',
                'contracts.status as contract_status',
                'invoices.status as invoice_status'
            ])
            ->orderBy('customers.id')
            ->get();
        return view('academic.customers', ['customers' => $customers]);
    });

    // Contratos (Diseño NoreTel Contratos)
    Route::get('/contracts', function () {
        $contracts = DB::table('contracts')
            ->join('customers', 'contracts.customer_id', '=', 'customers.id')
            ->select([
                'contracts.id',
                'customers.first_name',
                'customers.last_name',
                'contracts.start_date',
                'contracts.status',
                'contracts.final_price'
            ])
            ->orderBy('contracts.id')
            ->get();
        return view('academic.contracts', ['contracts' => $contracts]);
    });

    // Recibos (Diseño NoreTel Recibos)
    Route::get('/invoices', function () {
        $invoices = DB::table('invoices')
            ->join('contracts', 'invoices.contract_id', '=', 'contracts.id')
            ->join('customers', 'contracts.customer_id', '=', 'customers.id')
            ->select([
                'invoices.id',
                'invoices.invoice_number',
                'invoices.total_amount',
                'invoices.status',
                'customers.first_name',
                'customers.last_name',
                'customers.identity_document'
            ])
            ->orderBy('invoices.id')
            ->get();
        return view('academic.invoices', ['invoices' => $invoices]);
    });

    // Pagos
    Route::get('/payments', function () {
        $payments = DB::table('payments')
            ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->select([
                'payments.id',
                'payments.invoice_id',
                'invoices.invoice_number',
                'payments.amount',
                'payments.payment_method',
                'payments.status',
                'payments.created_at'
            ])
            ->orderBy('payments.id')
            ->get();
        return view('academic.payments', ['payments' => $payments]);
    });

    // Validaciones Yape (Diseño Exacto NoreTel Historial Yape)
    Route::get('/demo/yape', function () {
        $intents = DB::table('yape_payment_intents')
            ->leftJoin('customers', 'customers.id', '=', 'yape_payment_intents.customer_id')
            ->leftJoin('yape_client_evidences', 'yape_client_evidences.id', '=', 'yape_payment_intents.client_evidence_id')
            ->leftJoin('yape_receiver_events', 'yape_receiver_events.id', '=', 'yape_payment_intents.receiver_event_id')
            ->select([
                'yape_payment_intents.*',
                'customers.first_name',
                'customers.last_name',
                'customers.identity_document',
                'yape_client_evidences.parsed_amount as client_amount',
                'yape_client_evidences.security_code as client_code',
                'yape_receiver_events.parsed_amount as receiver_amount',
                'yape_receiver_events.security_code as receiver_code'
            ])
            ->orderBy('yape_payment_intents.id', 'desc')
            ->get();

        return view('academic.yape', [
            'intents' => $intents,
            'scenarios' => ScenarioRunner::SCENARIOS
        ]);
    });

    Route::post('/demo/yape', function (Request $request, ScenarioRunner $runner) {
        $data = $request->validate(['scenario' => 'required|in:'.implode(',', array_keys(ScenarioRunner::SCENARIOS))]);
        $result = $runner->run($data['scenario']);

        $scenarioMetadata = [
            'match' => [
                'name' => 'CP01 / CP05: Coincidencia Válida y Registro de Pago',
                'jira' => 'NYP-1 / NYP-5',
                'iso' => 'ISO/IEC 25010: Adecuación Funcional (Exactitud & Completitud)',
                'rule' => 'Cruce Exitoso 100%: Coinciden importe (S/ 65.00), código de operación y dígito de seguridad. Se aprueba la intención, se liquida la factura #1 a estado "paid" y se emite el asiento contable en "payments". Idempotente ante reintentos.',
            ],
            'amount_mismatch' => [
                'name' => 'CP02: Discrepancia en Importe Declarado',
                'jira' => 'NYP-2',
                'iso' => 'ISO/IEC 25010: Seguridad & Exactitud Funcional',
                'rule' => 'Bloqueo por Importe: Cliente declara S/ 64.00 vía captura WhatsApp pero la notificación push bancaria acredita S/ 65.00. El motor transiciona a "observed" con causal "amount_mismatch". La factura permanece "pending" y no se genera pago.',
            ],
            'security_mismatch' => [
                'name' => 'CP03: Código de Seguridad Discrepante (Alerta de Fraude)',
                'jira' => 'NYP-3',
                'iso' => 'ISO/IEC 25010: Integridad de Datos & Detección de Fraude',
                'rule' => 'Bloqueo por Código de Seguridad: Dígito de seguridad OCR (123) no concuerda con el emitido por el receptor bancario (999). El motor clasifica el evento como posible manipulación de comprobante ("observed"). Cuentas por cobrar intactas.',
            ],
            'missing_receiver' => [
                'name' => 'CP04: Ausencia de Evento Push del Receptor',
                'jira' => 'NYP-4',
                'iso' => 'ISO/IEC 25010: Fiabilidad & Tolerancia a Fallos Asíncronos',
                'rule' => 'Espera Transitoria: Se recibió captura del cliente pero el dispositivo Android receptor aún no ha emitido la notificación push correspondiente. El motor mantiene la intención en "waiting_receiver_event" protegiendo contra pagos fantasma.',
            ],
        ];

        $meta = $scenarioMetadata[$data['scenario']];
        $clientEv = DB::table('yape_client_evidences')->where('id', $result->client_evidence_id)->first();
        $receiverEv = DB::table('yape_receiver_events')->where('id', $result->receiver_event_id)->first();
        $invoice = DB::table('invoices')->where('id', $result->invoice_id)->first();

        $clientPayload = [
            'channel' => 'WhatsApp_OpenWA_Webhook',
            'phone' => $clientEv?->whatsapp_phone ?? '51961821320',
            'operation_code' => $clientEv?->operation_code ?? '900000001',
            'parsed_amount' => (float)($clientEv?->parsed_amount ?? 65.00),
            'security_code' => $clientEv?->security_code ?? '123',
            'ocr_confidence' => 0.98,
            'timestamp' => $clientEv?->occurred_at ?? '2026-08-10 10:00:00'
        ];

        $receiverPayload = $receiverEv ? [
            'channel' => 'Android_Notification_Listener',
            'device_serial' => $receiverEv->device_serial ?? 'PIXEL7-ISP-RECEPTOR-01',
            'title' => '¡Te llegó un Yape!',
            'operation_code' => $receiverEv->operation_code,
            'parsed_amount' => (float)$receiverEv->parsed_amount,
            'security_code' => $receiverEv->security_code,
            'timestamp' => $receiverEv->occurred_at ?? '2026-08-10 10:00:00'
        ] : null;

        $telemetry = [
            'scenario_key' => $data['scenario'],
            'scenario_name' => $meta['name'],
            'jira_ticket' => $meta['jira'],
            'iso_category' => $meta['iso'],
            'rule_explanation' => $meta['rule'],
            'intent_number' => $result->intent_number,
            'status' => $result->status,
            'observed_reason' => $result->observed_reason,
            'payment_id' => $result->payment_id,
            'invoice_id' => $result->invoice_id,
            'invoice_status' => $invoice?->status,
            'client_amount' => $clientEv?->parsed_amount ?? 65.00,
            'client_code' => $clientEv?->security_code ?? '123',
            'receiver_amount' => $receiverEv?->parsed_amount,
            'receiver_code' => $receiverEv?->security_code,
            'client_payload_json' => json_encode($clientPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'receiver_payload_json' => $receiverPayload ? json_encode($receiverPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '{"status": "PENDING_NOTIFICATION", "message": "No push notification received from Android receptor"}',
            'replayed' => (bool)$result->getAttribute('yape_reconciliation_already_completed'),
            'timestamp' => date('d/m/Y H:i:s')
        ];

        return redirect('/demo/yape')
            ->with('result', $result->intent_number.': '.$result->status)
            ->with('telemetry', $telemetry);
    });
});
