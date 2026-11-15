@extends('academic.layout')

@section('content')
<div class="page-title-row">
    <div>
        <h1>Cuaderno de Pagos</h1>
        <div class="page-subtitle">Registro contable y trazabilidad de ingresos recaudados</div>
    </div>
</div>

<div class="crm-table-card">
    <div class="table-container">
        <table class="noretel-table">
            <thead>
                <tr>
                    <th>ID PAGO</th>
                    <th>RECIBO ASOCIADO</th>
                    <th>MONTO RECIBIDO</th>
                    <th>MÉTODO DE PAGO</th>
                    <th>ESTADO</th>
                    <th>FECHA Y HORA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $p)
                <tr>
                    <td><strong>#PAY-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td style="color: #0284c7; font-weight: 600;">{{ $p->invoice_number }}</td>
                    <td><strong style="color: #059669; font-size: 14px;">S/ {{ number_format((float)$p->amount, 2) }}</strong></td>
                    <td>
                        <span class="pill-plan" style="background: #fdf2f8; color: #db2777; border: 1px solid #fbcfe8;">
                            <i class="fa-solid fa-mobile-screen"></i> {{ strtoupper($p->payment_method) }}
                        </span>
                    </td>
                    <td>
                        <span class="pill-status-paid"><i class="fa-solid fa-check"></i> Registrado</span>
                    </td>
                    <td style="color: #64748b; font-size: 12px;">{{ date('d/m/Y H:i', strtotime($p->created_at)) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">
                        No existen pagos contables aún. Ejecute un escenario válido en Simulación Yape para registrar un cobro.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
