<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Colegio de Antropólogos</title>

    @vite(['resources/css/login.css'])

    <style>
        .background {
            background-image: url('{{ asset('images/fondos/antropologos.jpg') }}');
        }
    </style>
</head>

<body>

<div class="background"></div>

<div class="login-wrapper">

    <div class="login-container">

        <div class="logo">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}" alt="Logo Colegio de Antropólogos">
        </div>

        <h2>Acceso al Administrador</h2>
        <p class="intro-text">Inicia sesión para gestionar el sistema institucional del Colegio de Antropólogos del Perú – Región Centro.</p>

        @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form action="/login" method="POST">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Contraseña</label>

                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-pass" onclick="togglePassword()">👁</span>
                </div>
            </div>


            <button class="btn-login" type="submit">Entrar</button>

            <p class="register-link">
                ¿No tienes cuenta? <a href="/register">Crear cuenta</a>
            </p>
        </form>

    </div>

</div>
<script>

function togglePassword(){

    const pass = document.getElementById('password');

    pass.type = pass.type === "password"
        ? "text"
        : "password";
}

</script>

</body>
</html>
