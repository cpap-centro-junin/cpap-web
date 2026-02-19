<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Colegio de Antropólogos del Perú</title>

    @vite(['resources/css/app.css'])

    <style>
        .background {
            background-image: url('{{ asset('images/fondos/antropologos.jpg') }}');
        }
    </style>
</head>
<body>

<div class="background"></div>

<div class="register-wrapper">

    <div class="register-card">

        <div class="register-header">
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}">
            <h2>Registro Institucional</h2>
        </div>

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
                    <input type="text" name="name" placeholder="Nombre completo" required>
                </div>

                <div class="input-group">
                    <input type="email" value="{{ $inv->email ?? '' }}" disabled>
                    <input type="hidden" name="email" value="{{ $inv->email ?? '' }}">
                </div>
            </div>

 
            <div class="form-row">

                <div class="input-group password-group">
                    <input type="password" id="password"
                        name="password"
                        placeholder="Contraseña"
                        required>

                    <span class="toggle-password" onclick="togglePassword('password')">👁</span>

                    <div class="strength-bar">
                        <div id="strength-fill"></div>
                    </div>

                    <small id="strength-text"></small>

                    <ul class="requirements">
                        <li id="req-length">Mínimo 8 caracteres</li>
                        <li id="req-upper">Una mayúscula</li>
                        <li id="req-lower">Una minúscula</li>
                        <li id="req-number">Un número</li>
                        <li id="req-special">Un símbolo (@$!%*?&)</li>
                    </ul>
                </div>

                <div class="input-group password-group">
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repetir contraseña"
                        required>

                    <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁</span>

                    <small id="match-msg"></small>
                </div>

            </div>

            <button class="btn-register" id="registerBtn" disabled>
                Crear Cuenta
            </button>

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
