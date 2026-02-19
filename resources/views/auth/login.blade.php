<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Colegio de Antropólogos del Perú</title>

    @vite(['resources/css/app.css'])

    <style>
        .background {
            background-image: url('{{ asset('images/fondos/antropologos.jpg') }}');
        }
    </style>
</head>
<body>

<div class="background"></div>

<div class="login-wrapper">

    <div class="login-card">

        <div class="login-header">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}" 
                 alt="Colegio de Antropólogos del Perú">
            <h2>Acceso al Administrador</h2>
        </div>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf

            <div class="input-group">
                <input type="email"
                       name="email"
                       placeholder="Correo institucional"
                       required>
            </div>

            <div class="input-group password-group">
                <input type="password"
                       name="password"
                       id="password"
                       placeholder="Contraseña"
                       required>
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>

            <div class="extra-options">
                <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn-login">
                Iniciar Sesión
            </button>

        </form>

    </div>

</div>

<script>
function togglePassword(){
    const pass = document.getElementById('password');
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
