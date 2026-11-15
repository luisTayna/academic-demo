@extends('academic.layout')

@section('content')
<div class="page-header">
    <p class="eyebrow">ENTRADAS SINTÉTICAS · ALGORITMO REAL</p>
    <h1>Laboratorio de Simulación: Conciliación Yape</h1>
    <p class="subtitle">Dispare interactivamente los escenarios de prueba funcionales. El sistema ejecuta el servicio real <code>YapeReconciliationService</code> para contrastar la evidencia reportada por el cliente frente al evento del receptor.</p>
</div>

@php
    $scenario_meta = [
        'match' => [
            'title' => 'Conciliación Válida',
            'class' => 'match',
            'badge' => 'CP01 / CP05 (Éxito)',
            'badge_class' => 'badge-cp1',
            'desc' => 'Cliente y receptor coinciden exactamente en S/ 65.00 y código de seguridad. Resultado: Intención validada, pago registrado y factura marcada como pagada. La re-ejecución demuestra idempotencia.'
        ],
        'amount_mismatch' => [
            'title' => 'Discrepancia en Importe',
            'class' => 'amount_mismatch',
            'badge' => 'CP02 (Negativo)',
            'badge_class' => 'badge-cp2',
            'desc' => 'El cliente reporta S/ 65.00 pero el receptor notifica abono real de S/ 50.00. Resultado: Intención observada, sin registro de pago y factura permanece pendiente.'
        ],
        'security_mismatch' => [
            'title' => 'Código de Operación Inválido',
            'class' => 'security_mismatch',
            'badge' => 'CP03 (Rechazo Seguro)',
            'badge_class' => 'badge-cp3',
            'desc' => 'Montos coinciden en S/ 65.00 pero los códigos de seguridad difieren (posible comprobante manipulado). Resultado: Intención observada sin efecto económico.'
        ],
        'missing_receiver' => [
            'title' => 'Falta de Notificación Bancaria',
            'class' => 'missing_receiver',
            'badge' => 'CP04 (Espera Asíncrona)',
            'badge_class' => 'badge-cp4',
            'desc' => 'Cliente sube captura pero la notificación push del banco aún no llega al servidor. Resultado: Estado "waiting_receiver_event" a la espera de conciliación.'
        ],
    ];
@endphp

<div class="scenario-grid">
    @foreach($scenarios as $scenario => $invoice)
    <form method="post" action="/demo/yape" class="scenario-card {{ $scenario_meta[$scenario]['class'] }}">
        @csrf
        <input type="hidden" name="scenario" value="{{ $scenario }}">
        <div>
            <div class="scenario-header">
                <h3>{{ $scenario_meta[$scenario]['title'] }}</h3>
                <span class="scenario-badge {{ $scenario_meta[$scenario]['badge_class'] }}">
                    {{ $scenario_meta[$scenario]['badge'] }}
                </span>
            </div>
            <div class="scenario-invoice">
                <i class="fa-solid fa-receipt"></i> Recibo Ficticio #{{ $invoice }} · Importe S/ 65.00
            </div>
            <p class="scenario-desc">{{ $scenario_meta[$scenario]['desc'] }}</p>
        </div>
        <button class="btn-primary" style="align-self: flex-start;">
            <i class="fa-solid fa-bolt"></i>
            <span>Ejecutar Escenario</span>
        </button>
    </form>
    @endforeach
</div>

<section class="panel">
    <h2><i class="fa-solid fa-table-list" style="color: #0099ff; margin-right: 8px;"></i> Registro Histórico de Intenciones Conciliadas</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Intención</th>
                    <th>Recibo</th>
                    <th>Estado de Dominio</th>
                    <th>ID de Pago</th>
                    <th>Motivo de Observación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($intents as $intent)
                <tr>
                    <td><strong>{{ $intent->intent_number }}</strong></td>
                    <td>Factura #{{ $intent->invoice_id }}</td>
                    <td>
                        @if($intent->status === 'validated')
                            <span class="status-tag tag-validated"><i class="fa-solid fa-check"></i> Validado</span>
                        @elseif($intent->status === 'observed')
                            <span class="status-tag tag-observed"><i class="fa-solid fa-xmark"></i> Observado</span>
                        @elseif($intent->status === 'waiting_receiver_event')
                            <span class="status-tag tag-waiting"><i class="fa-solid fa-clock"></i> En Espera</span>
                        @else
                            <span class="status-tag tag-pending">{{ $intent->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($intent->payment_id)
                            <span class="status-tag tag-paid">Pago #{{ $intent->payment_id }}</span>
                        @else
                            <span style="color: #94a3b8;">—</span>
                        @endif
                    </td>
                    <td style="color: #64748b; font-size: 12.5px;">
                        {{ $intent->observed_reason ?? 'Sin observaciones' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">
                        No se ha ejecutado ningún escenario aún. Presione "Ejecutar Escenario" arriba.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
