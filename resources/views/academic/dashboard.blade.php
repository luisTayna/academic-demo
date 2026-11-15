@extends('academic.layout')

@section('content')
<div class="page-title-row">
    <div>
        <h1>Dashboard General</h1>
        <div class="page-subtitle">NoreTEL CRM · Resumen ejecutivo del módulo de facturación y pruebas de conciliación Yape</div>
    </div>
    <div class="page-actions-row">
        <a href="/demo/yape" class="btn-crm-green">
            <i class="fa-solid fa-mobile-screen-button"></i>
            <span>Ir a Validaciones Yape</span>
        </a>
    </div>
</div>

<!-- 4 Solid Color Cards (Image 2 style) -->
<div class="stat-cards-grid">
    <div class="stat-card-solid card-blue">
        <div class="stat-card-title">Clientes Registrados</div>
        <div class="stat-card-number">{{ $counts['customers'] }}</div>
    </div>
    <div class="stat-card-solid card-amber">
        <div class="stat-card-title">Recibos Emitidos</div>
        <div class="stat-card-number">{{ $counts['invoices'] }}</div>
    </div>
    <div class="stat-card-solid card-red">
        <div class="stat-card-title">Intenciones Observadas</div>
        <div class="stat-card-number">{{ $counts['yape_observed'] }}</div>
    </div>
    <div class="stat-card-solid card-cyan">
        <div class="stat-card-title">Pagos Conciliados</div>
        <div class="stat-card-number">{{ $counts['payments'] }}</div>
    </div>
</div>

<!-- Blue Operative Banner (Image 3 style) -->
<div class="operative-banner">
    <div>
        <div class="banner-eyebrow">LABORATORIO DE CALIDAD DE SOFTWARE (PA2)</div>
        <h2>Conciliación Automatizada de Pagos Yape</h2>
        <p>Datos ficticios estructurados sobre el algoritmo real del CRM. El motor contrasta la evidencia reportada por el cliente mediante WhatsApp frente al evento push emitido por el receptor Android.</p>
    </div>
    <div class="banner-actions">
        <a href="/demo/yape" class="btn-yellow-action">
            <i class="fa-solid fa-play"></i>
            <span>Ejecutar Casos QA</span>
        </a>
    </div>
</div>

<!-- Quick guide panel -->
<div class="crm-table-card">
    <div class="table-title-row">
        <h3><i class="fa-solid fa-clipboard-check" style="color: #00cc66; margin-right: 8px;"></i> Procedimiento de Evaluación para el Docente</h3>
    </div>
    <div style="font-size: 13.5px; line-height: 1.6; color: #475569;">
        <ol style="padding-left: 20px;">
            <li style="margin-bottom: 6px;">Navegue por <strong>Gestión de Clientes</strong>, <strong>Contratos</strong> y <strong>Recibos</strong> para verificar la base de datos sintética precargada (SQLite).</li>
            <li style="margin-bottom: 6px;">Abra <strong>Historial Yape</strong> en el menú lateral para ejecutar los 5 casos de prueba funcionales (CP01 a CP05).</li>
            <li>Observe el resultado inmediato en la tabla de auditoría: las intenciones observadas no generan pagos contables, mientras que la conciliación válida actualiza la factura automáticamente.</li>
        </ol>
    </div>
</div>
@endsection
