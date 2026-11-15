@extends('academic.layout')

@section('content')
<div class="page-header">
    <p class="eyebrow">NORETEL CRM · PANEL DE CONTROL</p>
    <h1>Resumen del Entorno de Demostración</h1>
    <p class="subtitle">Datos ficticios sobre los modelos de dominio reales del CRM. Esta demostración reproduce y valida el flujo crítico de conciliación de pagos Yape en un entorno controlado y seguro.</p>
</div>

<div class="cards">
    @php
        $meta = [
            'customers' => ['Clientes', 'fa-solid fa-users', 'icon-blue'],
            'contracts' => ['Contratos', 'fa-solid fa-file-contract', 'icon-purple'],
            'invoices'  => ['Recibos', 'fa-solid fa-file-invoice-dollar', 'icon-emerald'],
            'payments'  => ['Pagos', 'fa-solid fa-money-bill-wave', 'icon-green']
        ];
    @endphp
    @foreach($counts as $name => $count)
    <a class="card" href="/{{ $name }}">
        <div class="card-header-line">
            <span class="card-label">{{ $meta[$name][0] }}</span>
            <div class="card-icon {{ $meta[$name][2] }}">
                <i class="{{ $meta[$name][1] }}"></i>
            </div>
        </div>
        <strong>{{ $count }}</strong>
    </a>
    @endforeach
</div>

<section class="panel">
    <h2><i class="fa-solid fa-flask-vial" style="color: #0099ff; margin-right: 8px;"></i> Guía de Evaluación del Proceso de QA</h2>
    <div style="margin: 14px 0 20px 0; line-height: 1.6; font-size: 13.5px; color: #475569;">
        <p style="margin-bottom: 8px;"><strong>Pasos para la verificación interactiva:</strong></p>
        <ol style="padding-left: 20px;">
            <li>Inspeccione las entidades de <strong>Clientes</strong>, <strong>Contratos</strong> y <strong>Recibos</strong> sintéticos en el menú lateral.</li>
            <li>Ingrese a la sección de <strong>Simulación Yape</strong> y dispare cualquiera de los escenarios funcionales (CP01 al CP05).</li>
            <li>Observe el resultado transaccional inmediato: cambio de estado en la intención, generación del pago y actualización de la factura.</li>
        </ol>
    </div>
    
    <a class="btn-primary" href="/demo/yape">
        <i class="fa-solid fa-play"></i>
        <span>Abrir Simulación de Pagos Yape</span>
    </a>
    
    <div style="margin-top: 20px; padding: 12px 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 12.5px; color: #64748b;">
        <i class="fa-solid fa-info-circle" style="color: #0284c7; margin-right: 6px;"></i>
        El algoritmo de conciliación (<code>YapeReconciliationService::tryReconcile()</code>) y el registro de pagos (<code>PaymentService</code>) son el código fuente real extraído de producción, garantizando fidelidad técnica total.
    </div>
</section>
@endsection
