<?php
namespace App\Academic;

use Illuminate\Support\Facades\DB;
use Modules\Billing\Entities\YapeClientEvidence;
use Modules\Billing\Entities\YapePaymentIntent;
use Modules\Billing\Entities\YapeReceiverEvent;
use Modules\Billing\Services\YapeReconciliationService;

final class ScenarioRunner
{
    public const SCENARIOS = ['match' => 1, 'amount_mismatch' => 2, 'security_mismatch' => 3, 'missing_receiver' => 4];
    public function __construct(private YapeReconciliationService $reconciliation) {}

    public function run(string $scenario): YapePaymentIntent
    {
        IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        if (!isset(self::SCENARIOS[$scenario])) { throw new \InvalidArgumentException('Escenario desconocido.'); }
        return DB::transaction(function () use ($scenario) {
            $id = self::SCENARIOS[$scenario];
            $intent = YapePaymentIntent::where('intent_number', 'DEMO-YAPE-'.$id)->first();
            if (!$intent) {
                $operation = '90000000'.$id;
                $time = '2026-08-10 10:00:00';
                $intent = YapePaymentIntent::create(['intent_number' => 'DEMO-YAPE-'.$id, 'invoice_id' => $id, 'contract_id' => $id, 'customer_id' => $id, 'created_by' => 1, 'expected_amount' => 65, 'payment_mode' => 'single', 'whatsapp_phone' => '155501000'.$id, 'operation_code' => $operation, 'security_code' => '123', 'status' => YapePaymentIntent::STATUS_WAITING_CLIENT, 'source_payload' => ['user_id' => 1, 'academic_simulation' => true]]);
                $client = YapeClientEvidence::create(['yape_payment_intent_id' => $intent->id, 'customer_id' => $id, 'whatsapp_phone' => '155501000'.$id, 'image_path' => 'SIMULATED_NOT_AN_IMAGE', 'raw_text' => 'Evidencia ficticia: no se ejecutó OCR.', 'parsed_amount' => $scenario === 'amount_mismatch' ? 64 : 65, 'operation_code' => $operation, 'security_code' => '123', 'confidence' => 1, 'occurred_at' => $time, 'receiver_phone' => '1555010999', 'status' => 'parsed']);
                $intent->client_evidence_id = $client->id;
                if ($scenario !== 'missing_receiver') {
                    $receiver = YapeReceiverEvent::create(['yape_payment_intent_id' => $intent->id, 'device_serial' => 'SIMULATED_DEVICE', 'screenshot_path' => 'SIMULATED_NOT_AN_IMAGE', 'raw_text' => 'Notificación ficticia: no se contactó un teléfono.', 'parsed_amount' => 65, 'operation_code' => $operation, 'security_code' => $scenario === 'security_mismatch' ? '999' : '123', 'confidence' => 1, 'occurred_at' => $time, 'status' => 'parsed']);
                    $intent->receiver_event_id = $receiver->id;
                }
                $intent->save();
            }
            // Actual copied domain algorithm, unchanged; only its external inputs are synthetic.
            return $this->reconciliation->tryReconcile($intent->fresh());
        });
    }
}
