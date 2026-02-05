<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - CPAP</title>

    @vite(['resources/css/register.css'])

    <style>
        .background {
            background-image: url('{{ asset('images/fondos/antropologos.jpg') }}');
        }
    </style>
</head>

<body>

<div class="background"></div>

<div class="register-wrapper">

    <div class="register-container">

        <div class="logo">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}">
        </div>

        <h2>Crear Cuenta</h2>
        <p class="intro-text">Colegio de Antropólogos del Perú – Región Centro</p>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-row">

                <div class="input-group">
                    <label>Nombre completo</label>
                    <input type="text" name="name" required>
                </div>

                <div class="input-group">
                    <label>Correo electrónico</label>

                    <input type="email" value="{{ $inv->email ?? '' }}" disabled>
                    <input type="hidden" name="email" value="{{ $inv->email ?? '' }}">

                    <small>Este correo proviene de la invitación</small>
                </div>

            </div>



            <div class="form-row">

                <div class="input-group">
                    <label>Contraseña</label>

                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required>
                        <span class="toggle-pass" onclick="togglePassword()">👁</span>
                    </div>

                    <!-- Barra de seguridad -->
                    <div class="strength-bar">
                        <div id="strength-fill"></div>
                    </div>

                    <small id="strength-text"></small>

                    <!-- Requisitos -->
                    <ul class="requirements">
                        <li id="req-length">Mínimo 8 caracteres</li>
                        <li id="req-upper">Una mayúscula</li>
                        <li id="req-lower">Una minúscula</li>
                        <li id="req-number">Un número</li>
                        <li id="req-special">Un símbolo (@$!%*?&)</li>
                    </ul>
                </div>

                <div class="input-group">
                    <label>Repetir contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    <small id="match-msg"></small>
                </div>

            </div>



            <button class="btn-register" id="registerBtn" disabled>
                Crear cuenta
            </button>


            <div class="login-link">
                <a href="/login">¿Ya tienes cuenta? Inicia sesión</a>
            </div>

        </form>

    </div>

</div>

<script>

const password = document.getElementById('password');
const confirmPass = document.getElementById('password_confirmation');
const strengthFill = document.getElementById('strength-fill');
const strengthText = document.getElementById('strength-text');
const registerBtn = document.getElementById('registerBtn');

const reqLength = document.getElementById('req-length');
const reqUpper = document.getElementById('req-upper');
const reqLower = document.getElementById('req-lower');
const reqNumber = document.getElementById('req-number');
const reqSpecial = document.getElementById('req-special');

function checkPassword(){

    const val = password.value;

    let score = 0;

    const length = val.length >= 8;
    const upper = /[A-Z]/.test(val);
    const lower = /[a-z]/.test(val);
    const number = /[0-9]/.test(val);
    const special = /[@$!%*?&]/.test(val);

    toggle(reqLength, length);
    toggle(reqUpper, upper);
    toggle(reqLower, lower);
    toggle(reqNumber, number);
    toggle(reqSpecial, special);

    if(length) score++;
    if(upper) score++;
    if(lower) score++;
    if(number) score++;
    if(special) score++;

    // NIVEL
    if(score <= 2){
        strengthFill.style.width = "33%";
        strengthFill.style.background = "red";
        strengthText.textContent = "Contraseña NO segura";
        strengthText.style.color = "red";
    }
    else if(score <=4){
        strengthFill.style.width = "66%";
        strengthFill.style.background = "orange";
        strengthText.textContent = "Contraseña segura";
        strengthText.style.color = "orange";
    }
    else{
        strengthFill.style.width = "100%";
        strengthFill.style.background = "green";
        strengthText.textContent = "Contraseña MUY segura";
        strengthText.style.color = "green";
    }

    validateForm(length, upper, lower, number, special);
}

function toggle(el, condition){
    if(condition){
        el.classList.add("valid");
    }else{
        el.classList.remove("valid");
    }
}

function validateForm(length, upper, lower, number, special){

    const passwordsMatch = password.value === confirmPass.value;

    if(passwordsMatch){
        document.getElementById('match-msg').textContent = "Las contraseñas coinciden";
        document.getElementById('match-msg').style.color = "green";
    }else{
        document.getElementById('match-msg').textContent = "No coinciden";
        document.getElementById('match-msg').style.color = "red";
    }

    if(length && upper && lower && number && special && passwordsMatch){
        registerBtn.disabled = false;
    }else{
        registerBtn.disabled = true;
    }
}

password.addEventListener('input', checkPassword);
confirmPass.addEventListener('input', checkPassword);

/* Mostrar contraseña */
function togglePassword(){

    const type = password.type === "password" ? "text" : "password";
    password.type = type;
    confirmPass.type = type;
}

</script>


</body>
</html>
