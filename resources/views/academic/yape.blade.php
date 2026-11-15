@extends('academic.layout')

@section('content')
<!-- Header matching Image 4 -->
<div class="page-title-row">
    <div style="display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-mobile-screen-button" style="color: #00cc66; font-size: 22px;"></i>
        <div>
            <h1 style="margin: 0; font-size: 24px;">Validaciones Yape</h1>
        </div>
    </div>
    <div class="page-actions-row">
        <button class="btn-crm-blue">
            <i class="fa-solid fa-plus"></i>
            <span>+ Nuevo cobro</span>
        </button>
    </div>
</div>

<!-- Filter Bar matching Image 4 -->
<div class="filter-row">
    <input type="text" class="filter-input" placeholder="Buscar: Intent, operación, cliente, WhatsApp o recibo" style="max-width: 480px;">
    <select class="filter-select" style="min-width: 160px;"><option>Estado: Todos</option></select>
    <button class="topbar-icon-btn" style="width: 34px; height: 34px;" title="Buscar">
        <i class="fa-solid fa-magnifying-glass" style="font-size: 12px;"></i>
    </button>
    <button class="topbar-icon-btn" style="width: 34px; height: 34px;" title="Limpiar">
        <i class="fa-solid fa-xmark" style="font-size: 12px;"></i>
    </button>
</div>

<!-- Cyan Info Banner matching Image 4 -->
<div class="info-banner-yape">
    <i class="fa-solid fa-circle-info"></i>
    <div>
        <strong>Validación Asíncrona Automática:</strong> Aquí NO se sube captura manual. El intent se valida cruzando la captura recibida por WhatsApp/OpenWA con la notificación del Yape receptor en Android.
    </div>
</div>

<!-- QA Scenario Triggers Bar (The 4 Test Buttons) -->
<div class="qa-scenarios-bar">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
        <div>
            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-vial-circle-check" style="color: #0084ff;"></i>
                <span>Batería de Pruebas Funcionales Automatizadas (Rúbrica PA2)</span>
            </h3>
            <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                Haga clic en cualquiera de los botones para disparar la prueba en tiempo real y contrastar los resultados del motor.
            </div>
        </div>
        <span style="font-size: 11.5px; background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
            <i class="fa-solid fa-code-branch" style="color: #00cc66;"></i> Matriz Jira NYP-1 a NYP-5 · Motor Real
        </span>
    </div>

    <div class="scenarios-btn-row">
        <!-- CP01 -->
        <form method="post" action="/demo/yape" style="display: contents;">
            @csrf
            <input type="hidden" name="scenario" value="match">
            <button type="submit" class="btn-scenario-trigger btn-match">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                    <span class="scenario-btn-tag" style="background: #dcfce7; color: #15803d; margin: 0;">CP01 · NYP-1</span>
                    <span style="font-size: 10.5px; font-weight: 800; color: #059669; background: #f0fdf4; padding: 2px 6px; border-radius: 4px; border: 1px solid #bbf7d0;">PRUEBA 1</span>
                </div>
                <div class="scenario-btn-name">Conciliación Válida</div>
                <div class="scenario-btn-hint" style="margin-bottom: 12px;">Importes y códigos coinciden (S/ 65.00). Liquida recibo y emite pago.</div>
                <div class="btn-cta-action btn-cta-green">
                    <i class="fa-solid fa-play"></i> Ejecutar Prueba 1
                </div>
            </button>
        </form>

        <!-- CP02 -->
        <form method="post" action="/demo/yape" style="display: contents;">
            @csrf
            <input type="hidden" name="scenario" value="amount_mismatch">
            <button type="submit" class="btn-scenario-trigger btn-amount">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                    <span class="scenario-btn-tag" style="background: #fef3c7; color: #b45309; margin: 0;">CP02 · NYP-2</span>
                    <span style="font-size: 10.5px; font-weight: 800; color: #d97706; background: #fffbeb; padding: 2px 6px; border-radius: 4px; border: 1px solid #fde68a;">PRUEBA 2</span>
                </div>
                <div class="scenario-btn-name">Monto Discordante</div>
                <div class="scenario-btn-hint" style="margin-bottom: 12px;">Cliente declara S/ 64.00 vs receptor S/ 65.00. Rechazo seguro sin cobro.</div>
                <div class="btn-cta-action btn-cta-amber">
                    <i class="fa-solid fa-play"></i> Ejecutar Prueba 2
                </div>
            </button>
        </form>

        <!-- CP03 -->
        <form method="post" action="/demo/yape" style="display: contents;">
            @csrf
            <input type="hidden" name="scenario" value="security_mismatch">
            <button type="submit" class="btn-scenario-trigger btn-sec">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                    <span class="scenario-btn-tag" style="background: #fee2e2; color: #b91c1c; margin: 0;">CP03 · NYP-3</span>
                    <span style="font-size: 10.5px; font-weight: 800; color: #dc2626; background: #fef2f2; padding: 2px 6px; border-radius: 4px; border: 1px solid #fecaca;">PRUEBA 3</span>
                </div>
                <div class="scenario-btn-name">Código Alterado (Fraude)</div>
                <div class="scenario-btn-hint" style="margin-bottom: 12px;">Dígito OCR (123) ≠ Banco (999). Detección de fraude y estado observado.</div>
                <div class="btn-cta-action btn-cta-red">
                    <i class="fa-solid fa-play"></i> Ejecutar Prueba 3
                </div>
            </button>
        </form>

        <!-- CP04 -->
        <form method="post" action="/demo/yape" style="display: contents;">
            @csrf
            <input type="hidden" name="scenario" value="missing_receiver">
            <button type="submit" class="btn-scenario-trigger btn-miss">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                    <span class="scenario-btn-tag" style="background: #e0f2fe; color: #0369a1; margin: 0;">CP04 · NYP-4</span>
                    <span style="font-size: 10.5px; font-weight: 800; color: #0284c7; background: #f0f9ff; padding: 2px 6px; border-radius: 4px; border: 1px solid #bae6fd;">PRUEBA 4</span>
                </div>
                <div class="scenario-btn-name">Sin Push Receptor</div>
                <div class="scenario-btn-hint" style="margin-bottom: 12px;">Dispositivo receptor desconectado. Intención en espera transitoria segura.</div>
                <div class="btn-cta-action btn-cta-blue">
                    <i class="fa-solid fa-play"></i> Ejecutar Prueba 4
                </div>
            </button>
        </form>

        <!-- CP05 -->
        <form method="post" action="/demo/yape" style="display: contents;">
            @csrf
            <input type="hidden" name="scenario" value="idempotency">
            <button type="submit" class="btn-scenario-trigger btn-idem">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                    <span class="scenario-btn-tag" style="background: #f3e8ff; color: #7e22ce; margin: 0;">CP05 · NYP-5</span>
                    <span style="font-size: 10.5px; font-weight: 800; color: #7e22ce; background: #faf5ff; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9d5ff;">PRUEBA 5</span>
                </div>
                <div class="scenario-btn-name">Reintento / Idempotencia</div>
                <div class="scenario-btn-hint" style="margin-bottom: 12px;">Reenvío de intención liquidada. Retorna cobro previo sin duplicar en BD.</div>
                <div class="btn-cta-action btn-cta-purple">
                    <i class="fa-solid fa-play"></i> Ejecutar Prueba 5
                </div>
            </button>
        </form>
    </div>
</div>

<!-- Telemetry Result Card (Shown after clicking any test button) -->
@if(session('telemetry'))
@php $t = session('telemetry'); @endphp
<div class="telemetry-card">
    <div class="telemetry-header">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="background: #0f172a; color: white; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                    {{ $t['jira_ticket'] ?? 'QA-CASE' }}
                </span>
                <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">
                    {{ $t['scenario_name'] }}
                </h3>
            </div>
            <div style="font-size: 11px; color: #64748b; margin-top: 3px; font-weight: 500;">
                <i class="fa-solid fa-award" style="color: #0084ff; margin-right: 4px;"></i> {{ $t['iso_category'] ?? 'ISO/IEC 25010' }}
            </div>
        </div>
        <span style="font-size: 11px; color: #64748b; font-weight: 600; white-space: nowrap;">
            <i class="fa-regular fa-clock"></i> {{ $t['timestamp'] }}
        </span>
    </div>

    <!-- Rule Explanation Banner -->
    <div style="padding: 10px 14px; background: #f8fafc; border-left: 3px solid #0084ff; border-radius: 6px; margin: 12px 0 16px; font-size: 12px; color: #334155; line-height: 1.5;">
        <strong>Evaluación del Criterio Algorítmico:</strong> {{ $t['rule_explanation'] ?? 'Procesamiento de conciliación asíncrona completado.' }}
    </div>

    <div class="telemetry-grid">
        <!-- Box 1: Evidencias Cruzadas -->
        <div class="telemetry-box">
            <div class="telemetry-box-title">1. Cruce de Evidencias Asíncronas</div>
            <div style="font-size: 12px; line-height: 1.6; color: #334155;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e2e8f0; padding-bottom: 3px;">
                    <span><i class="fa-brands fa-whatsapp" style="color: #25d366;"></i> WhatsApp (Cliente):</span>
                    <strong>S/ {{ number_format((float)$t['client_amount'], 2) }}</strong>
                </div>
                <div style="font-size: 11px; color: #64748b; margin-bottom: 4px;">Dígito Seg: <strong>{{ $t['client_code'] }}</strong></div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e2e8f0; padding-bottom: 3px; margin-top: 4px;">
                    <span><i class="fa-brands fa-android" style="color: #3ddc84;"></i> Receptor Android:</span>
                    @if($t['receiver_amount'])
                        <strong>S/ {{ number_format((float)$t['receiver_amount'], 2) }}</strong>
                    @else
                        <span style="color: #ef4444; font-weight: 700;">No Notificado</span>
                    @endif
                </div>
                <div style="font-size: 11px; color: #64748b;">Dígito Seg: <strong>{{ $t['receiver_code'] ?? 'N/A' }}</strong></div>
            </div>
        </div>

        <!-- Box 2: Decisión Algorítmica -->
        <div class="telemetry-box">
            <div class="telemetry-box-title">2. Veredicto del Motor (YapeReconciliationService)</div>
            <div class="telemetry-box-value" style="margin: 6px 0;">
                @if($t['status'] === 'validated')
                    <span class="pill-status-paid" style="font-size: 13px; padding: 4px 10px;">✔ VALIDADO (Aprobado)</span>
                @elseif($t['status'] === 'observed')
                    <span class="pill-status-observed" style="font-size: 13px; padding: 4px 10px;">✖ OBSERVADO (Rechazo Seguro)</span>
                @else
                    <span class="pill-status-waiting" style="font-size: 13px; padding: 4px 10px;">⏳ EN ESPERA (Push Pendiente)</span>
                @endif
            </div>
            @if($t['observed_reason'])
            <div style="font-size: 11px; color: #ef4444; font-weight: 600; margin-top: 4px;">
                Causal: <code>{{ $t['observed_reason'] }}</code>
            </div>
            @else
            <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 4px;">
                Criterio: Cero discrepancias
            </div>
            @endif
        </div>

        <!-- Box 3: Efecto Contable en Base de Datos -->
        <div class="telemetry-box">
            <div class="telemetry-box-title">3. Estado de Persistencia (SQLite)</div>
            <div style="font-size: 12px; line-height: 1.6; color: #334155;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e2e8f0; padding-bottom: 3px;">
                    <span>Factura #{{ $t['invoice_id'] }}:</span>
                    <strong style="text-transform: uppercase; color: {{ $t['invoice_status'] === 'paid' ? '#059669' : '#d97706' }};">
                        {{ $t['invoice_status'] === 'paid' ? '✔ PAGADA' : '⏳ PENDIENTE' }}
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 4px;">
                    <span>Asiento en Tabla Payments:</span>
                    @if($t['payment_id'])
                        <strong style="color: #059669;">Pago #{{ $t['payment_id'] }} Creado</strong>
                    @else
                        <span style="color: #64748b;">Ninguno (Sin cobro erróneo)</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($t['replayed'])
    <div style="margin-top: 12px; padding: 10px 14px; background: #ecfdf5; border-radius: 10px; border: 1px solid #a7f3d0; color: #065f46; font-size: 12px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-shield-check" style="font-size: 16px; color: #059669;"></i>
        <div>
            <strong>Garantía de Idempotencia Verificada (CP05 / NYP-5):</strong> La intención ya había sido validada. El motor retornó la transacción original sin duplicar el cobro ni generar un nuevo registro en <code>payments</code>.
        </div>
    </div>
    @endif

    <!-- Collapsible Technical Trace Section -->
    <details class="technical-trace-accordion">
        <summary class="technical-trace-summary">
            <div class="trace-summary-left">
                <div class="trace-icon-circle">
                    <i class="fa-solid fa-code"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span class="trace-title-text">Inspección Forense de Trazas Asíncronas</span>
                        <span class="trace-tag-pill"><i class="fa-solid fa-terminal"></i> JSON RAW</span>
                    </div>
                    <div class="trace-subtitle-text">Ver payloads simulados del Webhook OpenWA (OCR) y Android NotificationListener</div>
                </div>
            </div>
            <div class="trace-cta-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="text-closed">Inspeccionar Trazas JSON</span>
                <span class="text-open">Ocultar Trazas</span>
                <i class="fa-solid fa-chevron-down trace-arrow"></i>
            </div>
        </summary>
        <div class="technical-trace-content">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-brands fa-whatsapp" style="color: #25d366; margin-right: 4px;"></i> Webhook OpenWA (Extracción OCR)</span>
                        <span style="font-size: 10px; background: #dcfce7; color: #15803d; padding: 1px 6px; border-radius: 4px;">Evidencia Cliente</span>
                    </div>
                    <pre class="json-code-box">{{ $t['client_payload_json'] }}</pre>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-brands fa-android" style="color: #3ddc84; margin-right: 4px;"></i> Android Notification Listener</span>
                        <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 1px 6px; border-radius: 4px;">Evento Push Banco</span>
                    </div>
                    <pre class="json-code-box">{{ $t['receiver_payload_json'] }}</pre>
                </div>
            </div>
            @if(!empty($t['code_trace']))
            @php $ct = $t['code_trace']; @endphp
            <div style="margin-top: 14px; background: #0f172a; border-radius: 12px; padding: 14px 16px; border: 1px solid #1e293b; box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.4);">
                <div style="font-size: 12px; font-weight: 700; color: #38bdf8; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #1e293b; padding-bottom: 6px;">
                    <span><i class="fa-solid fa-code-branch" style="color: #38bdf8; margin-right: 6px;"></i> Pila de Ejecución Backend de Código Fuente (PHP / Laravel)</span>
                    <span style="font-size: 10px; background: #1e293b; color: #94a3b8; padding: 2px 6px; border-radius: 4px;">CAJA BLANCA</span>
                </div>
                <div style="font-family: 'Consolas', 'Courier New', monospace; font-size: 11.5px; color: #cbd5e1; line-height: 1.7;">
                    <div><span style="color: #64748b;">1. Ruta Web Invocada:</span> <span style="color: #4ade80;">{{ $ct['route'] }}</span></div>
                    <div><span style="color: #64748b;">2. Orquestador Determinista:</span> <span style="color: #facc15;">{{ $ct['scenario_runner'] }}</span></div>
                    <div><span style="color: #64748b;">3. Verificación de Aislamiento:</span> <span style="color: #38bdf8;">{{ $ct['isolation_check'] }}</span></div>
                    <div><span style="color: #64748b;">4. Clase de Dominio:</span> <span style="color: #f472b6; font-weight: bold;">{{ $ct['service_class'] }}</span></div>
                    <div><span style="color: #64748b;">5. Método Principal Invocado:</span> <strong style="color: #ffffff; background: #1e293b; padding: 1px 5px; border-radius: 3px;">{{ $ct['primary_method'] }}</strong></div>
                    <div><span style="color: #64748b;">6. Motor de Reglas Ejecutado:</span> <span style="color: #fb923c;">{{ $ct['rules_engine_method'] }}</span></div>
                    <div><span style="color: #64748b;">7. Rama de Decisión de Código:</span> <strong style="color: #22d3ee;">{{ $ct['executed_code_branch'] }}</strong></div>
                    <div><span style="color: #64748b;">8. Persistencia y Transacción:</span> <span style="color: #a78bfa;">{{ $ct['database_transaction'] }}</span></div>
                </div>
            </div>
            @endif

            <div style="margin-top: 12px; padding: 8px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11.5px; color: #64748b; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check" style="color: #00cc66;"></i>
                <div>
                    <strong>Aislamiento Determinista:</strong> El motor de conciliación procesó estos eventos mediante <code>ScenarioRunner.php</code> llamando al código real de producción sin dependencias externas.
                </div>
            </div>
        </div>
    </details>
</div>
@endif

<!-- Validaciones Yape Table matching Image 4 -->
<div class="crm-table-card">
    <div class="table-title-row">
        <h3>Historial de Intenciones Conciliadas</h3>
    </div>
    <div class="table-container">
        <table class="noretel-table">
            <thead>
                <tr>
                    <th>INTENT</th>
                    <th>CLIENTE</th>
                    <th>RECIBO</th>
                    <th>MONTO</th>
                    <th>OPERACIÓN</th>
                    <th>ESTADO</th>
                    <th>EVIDENCIAS</th>
                    <th>CREADO</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($intents as $intent)
                @php
                    $isTested = session('telemetry') && session('telemetry.intent_number') === $intent->intent_number;
                @endphp
                <tr class="{{ $isTested ? 'row-recently-tested' : '' }}">
                    <td>
                        <strong style="color: #0f172a;">{{ $intent->intent_number }}</strong>
                        @if($isTested)
                            <span style="display: inline-block; background: #00cc66; color: white; font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 4px; margin-left: 4px;">RECIÉN EJECUTADO</span>
                        @endif
                        <div style="font-size: 11px; color: #94a3b8;">Individual · S/ {{ number_format((float)$intent->expected_amount, 2) }}</div>
                    </td>
                    <td>
                        <strong>{{ $intent->first_name ?? 'Cliente' }} {{ $intent->last_name ?? 'Ficticio' }}</strong>
                        <div style="font-size: 11px; color: #64748b;">DNI: {{ $intent->identity_document ?? '40127689' }}</div>
                    </td>
                    <td>
                        <a href="/invoices" style="color: #0084ff; font-weight: 600; text-decoration: none;">
                            INV-00000{{ $intent->invoice_id }}
                        </a>
                    </td>
                    <td>
                        <strong style="font-size: 13.5px; color: #0f172a;">S/ {{ number_format((float)$intent->expected_amount, 2) }}</strong>
                    </td>
                    <td>
                        <span style="font-family: monospace; font-size: 12px; color: #475569;">{{ $intent->operation_code }}</span>
                    </td>
                    <td>
                        @if($intent->status === 'validated')
                            <span class="pill-status-paid" style="border-radius: 6px; padding: 2px 8px; font-size: 11px;">
                                Validado
                            </span>
                        @elseif($intent->status === 'observed')
                            <span class="pill-status-observed" style="border-radius: 6px; padding: 2px 8px; font-size: 11px;">
                                Observado
                            </span>
                        @else
                            <span class="pill-status-waiting" style="border-radius: 6px; padding: 2px 8px; font-size: 11px;">
                                En Espera
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-evidence whatsapp">WhatsApp</span>
                        @if($intent->receiver_event_id)
                            <span class="badge-evidence receptor">Receptor</span>
                        @else
                            <span class="badge-evidence missing">Sin Receptor</span>
                        @endif
                    </td>
                    <td style="font-size: 12px; color: #64748b;">
                        {{ date('d/m/Y H:i', strtotime($intent->created_at ?? '2026-11-14 10:00:00')) }}
                    </td>
                    <td style="text-align: right;">
                        <button type="button" class="btn-action-eye" title="Ver Detalles de Validación"
                                onclick="openAuditModal({
                                    intent: '{{ $intent->intent_number }}',
                                    customer: '{{ $intent->first_name ?? 'Cliente' }} {{ $intent->last_name ?? 'Ficticio' }}',
                                    dni: '{{ $intent->identity_document ?? '40127689' }}',
                                    invoice: 'INV-00000{{ $intent->invoice_id }}',
                                    expected: 'S/ {{ number_format((float)$intent->expected_amount, 2) }}',
                                    operation: '{{ $intent->operation_code }}',
                                    status: '{{ $intent->status }}',
                                    clientAmount: 'S/ {{ number_format((float)($intent->client_amount ?? 65.00), 2) }}',
                                    clientCode: '{{ $intent->client_code ?? '123' }}',
                                    receiverAmount: '{{ $intent->receiver_amount ? ('S/ '.number_format((float)$intent->receiver_amount, 2)) : 'No recibido' }}',
                                    receiverCode: '{{ $intent->receiver_code ?? 'N/A' }}',
                                    reason: '{{ $intent->observed_reason ?? 'Ninguna' }}',
                                    paymentId: '{{ $intent->payment_id ? ('#'.$intent->payment_id) : 'Ninguno' }}',
                                    date: '{{ date('d/m/Y H:i:s', strtotime($intent->created_at ?? '2026-11-14 10:00:00')) }}'
                                })">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #94a3b8; padding: 24px;">
                        No hay intenciones registradas. Presione cualquiera de los 4 botones superiores para disparar una prueba.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Auditoría Técnica Yape -->
<div id="auditModal" class="crm-modal-overlay" style="display: none;" onclick="if(event.target === this) closeAuditModal();">
    <div class="crm-modal-card">
        <div class="crm-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-file-shield"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;" id="modalIntentId">Auditoría de Intent</h3>
                    <div style="font-size: 11px; color: #64748b;">Trazabilidad completa de la transacción y concordancia asíncrona</div>
                </div>
            </div>
            <button type="button" class="crm-modal-close" onclick="closeAuditModal()">&times;</button>
        </div>

        <div class="crm-modal-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div class="modal-info-box">
                    <span class="modal-info-label">CLIENTE & IDENTIDAD</span>
                    <strong id="modalCustomer">-</strong>
                    <div style="font-size: 11px; color: #64748b;">DNI: <span id="modalDni">-</span></div>
                </div>
                <div class="modal-info-box">
                    <span class="modal-info-label">RECIBO VINCULADO</span>
                    <strong id="modalInvoice" style="color: #0084ff;">-</strong>
                    <div style="font-size: 11px; color: #64748b;">Monto Esperado: <span id="modalExpected">-</span></div>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; margin-bottom: 14px;">
                <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-code-compare" style="color: #0084ff; margin-right: 4px;"></i> Contraste de Evidencias Asíncronas
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12px;">
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px;">
                        <div style="color: #15803d; font-weight: 600;"><i class="fa-brands fa-whatsapp"></i> Evidencia WhatsApp (Cliente)</div>
                        <div style="margin-top: 4px;">Monto Extraído: <strong id="modalClientAmount">-</strong></div>
                        <div style="color: #64748b; font-size: 11px;">Dígito Seguridad: <span id="modalClientCode">-</span></div>
                    </div>
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px;">
                        <div style="color: #0284c7; font-weight: 600;"><i class="fa-brands fa-android"></i> Notificación Android (Receptor)</div>
                        <div style="margin-top: 4px;">Monto Acreditado: <strong id="modalReceiverAmount">-</strong></div>
                        <div style="color: #64748b; font-size: 11px;">Dígito Seguridad: <span id="modalReceiverCode">-</span></div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="modal-info-box">
                    <span class="modal-info-label">ESTADO DEL MOTOR</span>
                    <div id="modalStatusBadge" style="margin-top: 4px;">-</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Causal: <span id="modalReason">Ninguna</span></div>
                </div>
                <div class="modal-info-box">
                    <span class="modal-info-label">ASIENTO EN PAYMENTS</span>
                    <strong id="modalPaymentId" style="color: #059669;">-</strong>
                    <div style="font-size: 11px; color: #64748b;">Fecha: <span id="modalDate">-</span></div>
                </div>
            </div>
        </div>

        <div class="crm-modal-footer">
            <button type="button" class="btn-crm-pill" onclick="closeAuditModal()">Cerrar Auditoría</button>
        </div>
    </div>
</div>

<script>
function openAuditModal(data) {
    document.getElementById('modalIntentId').innerText = 'Auditoría: ' + data.intent;
    document.getElementById('modalCustomer').innerText = data.customer;
    document.getElementById('modalDni').innerText = data.dni;
    document.getElementById('modalInvoice').innerText = data.invoice;
    document.getElementById('modalExpected').innerText = data.expected;
    document.getElementById('modalClientAmount').innerText = data.clientAmount;
    document.getElementById('modalClientCode').innerText = data.clientCode;
    document.getElementById('modalReceiverAmount').innerText = data.receiverAmount;
    document.getElementById('modalReceiverCode').innerText = data.receiverCode;
    document.getElementById('modalReason').innerText = data.reason;
    document.getElementById('modalPaymentId').innerText = data.paymentId;
    document.getElementById('modalDate').innerText = data.date;

    const badgeContainer = document.getElementById('modalStatusBadge');
    if (data.status === 'validated') {
        badgeContainer.innerHTML = '<span class="pill-status-paid">✔ Validado (Cobrado)</span>';
    } else if (data.status === 'observed') {
        badgeContainer.innerHTML = '<span class="pill-status-observed">✖ Observado (Rechazo Seguro)</span>';
    } else {
        badgeContainer.innerHTML = '<span class="pill-status-waiting">⏳ En Espera de Receptor</span>';
    }

    document.getElementById('auditModal').style.display = 'flex';
}

function closeAuditModal() {
    document.getElementById('auditModal').style.display = 'none';
}
</script>
@endsection
