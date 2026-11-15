@extends('academic.layout')

@section('content')
<div class="login-box">
    <div style="text-align: center; margin-bottom: 24px;">
        <div class="logo-box" style="margin: 0 auto 12px auto; width: 48px; height: 48px; font-size: 24px;">N</div>
        <p class="eyebrow">EVALUACIÓN ACADÉMICA · PA2</p>
        <h1 style="font-size: 22px;">Acceso al Entorno de Pruebas</h1>
        <p style="font-size: 13px; color: #64748b;">NoreTEL CRM · Simulación del Flujo de Conciliación Yape</p>
    </div>

    <form method="post" action="/login">
        @csrf
        <label>
            Correo Electrónico de Prueba:
            <input name="email" type="email" value="evaluador@example.test" required>
        </label>
        
        <label>
            Contraseña de Acceso:
            <input name="password" type="password" value="DemoAcademica2026!" required autocomplete="current-password">
        </label>
        
        <button class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px; padding: 12px;">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Iniciar Sesión en el Prototipo</span>
        </button>
    </form>
    
    <div style="margin-top: 20px; padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 11.5px; color: #64748b; line-height: 1.5;">
        <i class="fa-solid fa-key" style="color: #0099ff; margin-right: 4px;"></i>
        <strong>Credenciales de evaluación local:</strong><br>
        Usuario: <code>evaluador@example.test</code><br>
        Clave: <code>DemoAcademica2026!</code>
    </div>
</div>
@endsection
