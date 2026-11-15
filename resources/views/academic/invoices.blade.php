@extends('academic.layout')

@section('content')
<!-- Header Row matching Image 3 -->
<div class="page-title-row">
    <div>
        <h1>Recibos de clientes</h1>
        <div class="page-subtitle">Emisión mensual, cobranzas y control de estados de deuda</div>
    </div>
</div>

<!-- Blue Operative Banner matching Image 3 -->
<div class="operative-banner">
    <div>
        <div class="banner-eyebrow">BANDEJA OPERATIVA</div>
        <h2>Recibos y constancias de clientes</h2>
        <p>Busca un cliente y abre su recibo, imprime la constancia térmica o reenvíala por WhatsApp sin entrar a pantallas técnicas.</p>
    </div>
    <div class="banner-actions">
        <button class="btn-yellow-action">
            <i class="fa-solid fa-bolt"></i>
            <span>⚡ Generar este mes</span>
        </button>
        <button class="btn-white-action">
            <i class="fa-solid fa-plus"></i>
            <span>+ Nuevo recibo</span>
        </button>
    </div>
</div>

<!-- Filter Bar matching Image 3 -->
<div class="filter-row">
    <input type="text" class="filter-input" placeholder="Nombre, DNI, teléfono o Nro. recibo">
    <select class="filter-select"><option>Estado: Todos</option></select>
    <input type="text" class="filter-select" placeholder="Desde: dd/mm/aaaa" style="width: 140px;">
    <input type="text" class="filter-select" placeholder="Hasta: dd/mm/aaaa" style="width: 140px;">
    <button class="btn-crm-blue" style="padding: 8px 16px;">Filtrar</button>
    <button class="btn-crm-pill">Limpiar</button>
</div>

<!-- Table Card matching Image 3 -->
<div class="crm-table-card">
    <div class="table-container">
        <table class="noretel-table">
            <thead>
                <tr>
                    <th>CLIENTE & RECIBO</th>
                    <th>PERIODO</th>
                    <th>VENCIMIENTO</th>
                    <th>MONTO</th>
                    <th>ESTADO</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $inv)
                @php
                    $isPaid = ($inv->status === 'paid');
                @endphp
                <tr>
                    <td>
                        <div class="client-avatar-cell">
                            <div class="avatar-circle" style="background: #e0f2fe; color: #0284c7; width: 34px; height: 34px;">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div>
                                <strong>{{ $inv->first_name }} {{ $inv->last_name }}</strong>
                                <div style="font-size: 11.5px; color: #64748b;">DNI: {{ $inv->identity_document }} · Tel: 984639420</div>
                                <div style="font-size: 11.5px; color: #0284c7; font-weight: 700; margin-top: 2px;">
                                    {{ $inv->invoice_number }} · Plan Start 150 MB
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size: 12.5px; color: #334155;">
                        <strong>Noviembre 2026</strong>
                        <div style="font-size: 11px; color: #94a3b8;">Emitido: 01/11/2026</div>
                    </td>
                    <td style="font-size: 12.5px; font-weight: 600; color: #475569;">
                        16/11/2026
                    </td>
                    <td>
                        <strong style="font-size: 15px; color: #0f172a;">S/ {{ number_format((float)$inv->total_amount, 2) }}</strong>
                    </td>
                    <td>
                        @if($isPaid)
                            <span class="pill-status-paid"><i class="fa-solid fa-check"></i> Pagada</span>
                        @else
                            <span class="pill-status-pending"><i class="fa-solid fa-clock"></i> Pendiente</span>
                        @endif
                    </td>
                    <td style="text-align: right; white-space: nowrap;">
                        <button class="btn-crm-pill" style="padding: 4px 10px; font-size: 11px; margin-right: 4px;">
                            <i class="fa-regular fa-eye"></i> Ver
                        </button>
                        <button class="btn-crm-pill" style="padding: 4px 10px; font-size: 11px; margin-right: 4px;">
                            <i class="fa-solid fa-ticket"></i> Ticket
                        </button>
                        <button class="btn-whatsapp-resend" title="Reenviar constancia por WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i> Reenviar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
