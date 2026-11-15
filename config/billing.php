<?php
// No environment variable can enable an external integration in this demo.
return ['name' => 'Billing', 'yape' => [
    'bot_enabled' => false, 'receiver_name' => 'RECEPTOR FICTICIO', 'receiver_phone' => '1555010999',
    'confidence_threshold' => 0.88, 'time_tolerance_minutes' => 10, 'timezone_offset_minutes' => 300,
    'ocr_mode' => 'disabled', 'storage_disk' => 'local',
    'openwa' => ['ocr_enabled' => false, 'send_receipt_on_validation' => false, 'api_url' => null],
], 'payment_reminders' => ['enabled' => false], 'overdue_reminders' => ['enabled' => false], 'invoice' => ['auto_generation' => false]];
