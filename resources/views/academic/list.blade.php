@extends('academic.layout')

@section('content')
<div class="page-header">
    <p class="eyebrow">REGISTROS SINTÉTICOS · INSPECCIÓN DE DOMINIO</p>
    <h1>{{ $title }}</h1>
    <p class="subtitle">Consulta de registros ficticios en la base de datos local SQLite. La información es estructuralmente idéntica al CRM pero no expone datos personales reales.</p>
</div>

<div class="panel">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    @foreach($columns as $column)
                    <th>{{ ['id'=>'ID','first_name'=>'Nombre','last_name'=>'Apellido','identity_document'=>'DNI Ficticio','email'=>'Correo Electrónico','customer_id'=>'Cliente','start_date'=>'Fecha Inicio','status'=>'Estado','final_price'=>'Tarifa (S/)','invoice_number'=>'N° Recibo','contract_id'=>'Contrato','total_amount'=>'Total (S/)','invoice_id'=>'Recibo','amount'=>'Monto Pagado (S/)','payment_method'=>'Método'][$column] ?? $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    @foreach($columns as $column)
                    <td>
                        @if($column === 'status')
                            @if($record->$column === 'paid')
                                <span class="status-tag tag-paid"><i class="fa-solid fa-check"></i> Pagado</span>
                            @elseif($record->$column === 'pending')
                                <span class="status-tag tag-pending"><i class="fa-solid fa-clock"></i> Pendiente</span>
                            @else
                                <span class="status-tag tag-pending">{{ $record->$column }}</span>
                            @endif
                        @elseif($column === 'total_amount' || $column === 'final_price' || $column === 'amount')
                            <strong>S/ {{ number_format((float)$record->$column, 2) }}</strong>
                        @else
                            {{ $record->$column }}
                        @endif
                    </td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) }}" style="text-align: center; color: #94a3b8; padding: 24px;">
                        No existen registros disponibles en esta tabla.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
