@extends('academic.layout')

@section('content')
<!-- Header Row matching Image 1 -->
<div class="page-title-row">
    <div>
        <h1>Clientes</h1>
        <div class="page-subtitle">Registro comercial · contratos · historial de pagos</div>
    </div>
    <div class="page-actions-row">
        <span class="btn-crm-pill">
            <i class="fa-solid fa-link"></i>
            <span>Clientes ≠ Usuarios del sistema</span>
        </span>
        <button class="btn-crm-outline">
            <i class="fa-solid fa-rotate-left"></i>
            <span>Cliente histórico</span>
        </button>
        <button class="btn-crm-green">
            <i class="fa-solid fa-plus"></i>
            <span>+ Nuevo cliente</span>
        </button>
    </div>
</div>

<!-- Filter Pills Row matching Image 1 -->
<div class="filter-row">
    <input type="text" class="filter-input" placeholder="Nombre, DNI, celular o correo" value="">
    <select class="filter-select"><option>Estado Cliente (Todos)</option></select>
    <select class="filter-select"><option>Contrato (Todos)</option></select>
    <select class="filter-select"><option>Estado Pago (Todos)</option></select>
    <select class="filter-select"><option>Perfil (Todos)</option></select>
    <select class="filter-select"><option>Zonas (Todas)</option></select>
    <select class="filter-select"><option>Planes (Todos)</option></select>
    <button class="topbar-icon-btn" title="Restablecer filtros" style="width: 32px; height: 32px;">
        <i class="fa-solid fa-rotate-right" style="font-size: 11px;"></i>
    </button>
</div>

<!-- Table Card matching Image 1 -->
<div class="crm-table-card">
    <div class="table-container">
        <table class="noretel-table">
            <thead>
                <tr>
                    <th style="width: 40px;">N°</th>
                    <th>CLIENTE</th>
                    <th>DNI</th>
                    <th>CELULAR</th>
                    <th>PLAN</th>
                    <th>ZONA</th>
                    <th>FECHA PAGO</th>
                    <th>ESTADO</th>
                    <th>CÓD. COMPR...</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $c)
                @php
                    $initials = strtoupper(substr($c->first_name, 0, 1) . substr($c->last_name, 0, 1));
                    $isPaid = ($c->invoice_status === 'paid');
                @endphp
                <tr>
                    <td style="color: #94a3b8; font-weight: 600;">{{ $index + 1 }}</td>
                    <td>
                        <div class="client-avatar-cell">
                            <div class="avatar-circle" style="background: {{ ['#00d2d3', '#0084ff', '#8b5cf6', '#00cc66'][$index % 4] }};">
                                {{ $initials }}
                            </div>
                            <div class="client-info">
                                <strong>{{ $c->first_name }} {{ $c->last_name }}</strong>
                                <div class="client-badges">
                                    <span class="badge-micro-active">ACTIVO</span>
                                    <span class="badge-micro-contract">CONTRATO: ACTIVO</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 500;">{{ $c->identity_document }}</td>
                    <td style="color: #64748b;">96182132{{ $index }}</td>
                    <td>
                        <span class="pill-plan">
                            <i class="fa-solid fa-circle" style="font-size: 6px;"></i> 150 Mbps - S/65
                        </span>
                    </td>
                    <td style="color: #059669; font-weight: 600; font-size: 12px;">● N/A</td>
                    <td style="color: #64748b; font-size: 12.5px;">{{ 15 + $index * 5 }}/Nov</td>
                    <td>
                        @if($isPaid)
                            <span class="pill-status-paid">● Pagado</span>
                        @else
                            <span class="pill-status-pending">● Pendiente</span>
                        @endif
                    </td>
                    <td style="color: #94a3b8; font-size: 12px; font-family: monospace;">#ISP-2026-00{{ $c->id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
