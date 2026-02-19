<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - CPAP</title>

    @vite(['resources/css/app.css'])

    <style>
        .background {
            background-image: url('{{ asset('images/fondos/antropologos.jpg') }}');
        }
    </style>
</head>
<body>

<div class="background"></div>

<div class="forgot-wrapper">

    <div class="forgot-card">

        <div class="forgot-header">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}" alt="CPAP">
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu correo institucional y te enviaremos un enlace de recuperación.</p>
        </div>

        @if (session('status'))
            <div class="success-box">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('forgot-password') }}">
            @csrf

            <div class="input-group">
                <input type="email"
                       name="email"
                       placeholder="Correo institucional"
                       required>
            </div>

            <button type="submit" class="btn-forgot">
                Enviar Enlace de Recuperación
            </button>

            <div class="back-login">
                <a href="/login">Volver al inicio de sesión</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
