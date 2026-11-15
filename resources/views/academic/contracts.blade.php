@extends('academic.layout')

@section('content')
<!-- Header Row matching Image 2 -->
<div class="page-title-row">
    <div>
        <h1>Gestión de Contratos</h1>
        <div class="page-subtitle">Listado de contratos de servicio de internet por fibra óptica</div>
    </div>
    <div class="page-actions-row">
        <button class="btn-crm-pill">
            <i class="fa-solid fa-filter"></i>
            <span>Filtros</span>
        </button>
        <button class="btn-crm-blue">
            <i class="fa-solid fa-plus"></i>
            <span>+ Nuevo Contrato</span>
        </button>
    </div>
</div>

<!-- 4 Solid Color Cards matching Image 2 -->
<div class="stat-cards-grid">
    <div class="stat-card-solid card-blue">
        <div class="stat-card-title">Contratos Activos</div>
        <div class="stat-card-number">{{ count($contracts) }}</div>
    </div>
    <div class="stat-card-solid card-amber">
        <div class="stat-card-title">Por Vencer</div>
        <div class="stat-card-number">0</div>
    </div>
    <div class="stat-card-solid card-red">
        <div class="stat-card-title">Vencidos</div>
        <div class="stat-card-number">0</div>
    </div>
    <div class="stat-card-solid card-cyan">
        <div class="stat-card-title">Pendientes</div>
        <div class="stat-card-number">0</div>
    </div>
</div>

<!-- Table Card matching Image 2 -->
<div class="crm-table-card">
    <div class="table-title-row">
        <h3>Listado de Contratos</h3>
    </div>
    <div class="table-container">
        <table class="noretel-table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>CLIENTE</th>
                    <th>PLAN</th>
                    <th>FECHAS</th>
                    <th>ESTADO</th>
                    <th>PRECIO (S/)</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $c)
                <tr>
                    <td style="font-weight: 600; color: #475569;">{{ 450 + $c->id }}</td>
                    <td>
                        <strong style="color: #0284c7;">{{ $c->first_name }} {{ $c->last_name }}</strong>
                    </td>
                    <td style="color: #475569;">Plan Start 150 MB</td>
                    <td style="font-size: 12px; color: #64748b; line-height: 1.4;">
                        <div><strong>Inicio:</strong> {{ date('d/m/Y', strtotime($c->start_date)) }}</div>
                        <div><strong>Fin:</strong> Indefinido</div>
                    </td>
                    <td>
                        <span class="pill-status-paid" style="border-radius: 6px; padding: 2px 8px; font-size: 10.5px;">
                            Activo
                        </span>
                    </td>
                    <td>
                        <strong>{{ number_format((float)$c->final_price, 2) }}</strong>
                    </td>
                    <td style="text-align: right;">
                        <button class="btn-action-eye" title="Ver Contrato">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
