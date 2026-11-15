<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoreTEL CRM · Suite de Pruebas y Conciliación Yape</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/demo.css">
</head>
<body>
    <header class="app-header">
        <div class="brand-container">
            <div class="logo-box">N</div>
            <div class="brand-text">
                <strong>NoreTEL CRM</strong>
                <span>Módulo de Facturación & QA</span>
            </div>
        </div>
        <div class="header-badges">
            <div class="env-pill">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Entorno Académico Aislado (PA2) · Datos ficticios</span>
            </div>
            @auth
            <div class="user-pill">
                <i class="fa-solid fa-user-circle"></i>
                <span>Evaluador: Yhon Mamani Kjuro</span>
            </div>
            @endauth
        </div>
    </header>

    <div class="app-layout">
        <aside class="sidebar">
            <div class="sidebar-title">MENÚ PRINCIPAL</div>
            <nav class="nav-menu">
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Resumen</span>
                </a>
                <a href="/customers" class="{{ request()->is('customers') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Clientes</span>
                </a>
                <a href="/contracts" class="{{ request()->is('contracts') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-contract"></i>
                    <span>Contratos</span>
                </a>
                <a href="/invoices" class="{{ request()->is('invoices') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Recibos</span>
                </a>
                <a href="/payments" class="{{ request()->is('payments') ? 'active' : '' }}">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Pagos</span>
                </a>
                <a href="/demo/yape" class="yape-link {{ request()->is('demo/yape*') ? 'active' : '' }}">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    <span>Simulación Yape</span>
                    <span class="pulse-badge">QA</span>
                </a>
            </nav>

            @auth
            <div class="sidebar-footer">
                <form method="post" action="/logout">
                    @csrf
                    <button class="logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <main class="main-content">
            @if(session('result'))
            <div class="alert-box success">
                <i class="fa-solid fa-circle-check"></i>
                <div>
                    <strong>Resultado del Escenario:</strong> {{ session('result') }}
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="alert-box error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>{{ $errors->first() }}</div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
