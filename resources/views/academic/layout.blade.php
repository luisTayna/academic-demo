<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NorETEL CRM · Suite de Pruebas y Conciliación Yape</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/demo.css">
</head>
<body>
    <div class="crm-wrapper">
        <!-- Sidebar NoreTel Next-Gen -->
        <aside id="sidebar">
            <div class="sidebar-brand">
                <div class="logo-initial">N</div>
                <div class="sidebar-brand-text">NorETEL CRM</div>
            </div>

            <div class="sidebar-nav-container">
                <div class="sidebar-heading">OPERACIONES</div>
                <div class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-heading">CLIENTES</div>
                <div class="nav-item">
                    <a href="/customers" class="nav-link {{ request()->is('customers') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestión de Clientes</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/contracts" class="nav-link {{ request()->is('contracts') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-contract"></i>
                        <span>Gestión de Contratos</span>
                    </a>
                </div>

                <div class="sidebar-heading">FACTURACIÓN & COBROS</div>
                <div class="nav-item">
                    <a href="/invoices" class="nav-link {{ request()->is('invoices') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>Recibos de Clientes</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/payments" class="nav-link {{ request()->is('payments') ? 'active' : '' }}">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span>Cuaderno de Pagos</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="/demo/yape" class="nav-link yape-highlight {{ request()->is('demo/yape*') ? 'active' : '' }}">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span>Historial Yape</span>
                        <span class="yape-pill">QA</span>
                    </a>
                </div>
            </div>

            @auth
            <div class="sidebar-footer">
                <form method="post" action="/logout">
                    @csrf
                    <button class="btn-logout" title="Cerrar Sesión">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <header class="topbar">
                <div class="topbar-left">
                    <div class="academic-badge">
                        <i class="fa-solid fa-flask-vial"></i>
                        <span>Entorno Académico PA2 · Datos ficticios</span>
                    </div>
                </div>
                <div class="topbar-right">
                    <button class="topbar-icon-btn" title="Notificaciones">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                    @auth
                    <div class="user-profile-badge">
                        <div class="user-avatar">YM</div>
                        <span class="user-name">Yhon Mamani (QA)</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #94a3b8;"></i>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="page-content">
                @if(session('result'))
                <div class="alert-box-crm success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong>Ejecución Registrada:</strong> {{ session('result') }}
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert-box-crm error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
