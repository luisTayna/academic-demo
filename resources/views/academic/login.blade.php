@extends('academic.layout')
@section('content')
<section class="panel login"><p class="eyebrow">EVALUACIÓN LOCAL</p><h1>Ingresar a la demostración</h1><p>Entorno académico con cuatro clientes ficticios. No conecta con la empresa.</p><form method="post" action="/login">@csrf<label>Correo de demostración<input name="email" type="email" value="evaluador@example.test" required></label><label>Contraseña de demostración<input name="password" type="password" required autocomplete="current-password"></label><button class="primary">Ingresar</button></form><small>Credenciales exclusivamente locales: evaluador@example.test / DemoAcademica2026!</small></section>
@endsection
