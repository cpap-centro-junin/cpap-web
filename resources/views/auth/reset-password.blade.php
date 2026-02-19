<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña - CPAP</title>

    @vite(['resources/css/app.css'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <img src="{{ asset('images/logos/cpap-logo.jpg') }}">
            <h2>Establecer Nueva Contraseña</h2>
            <p>Ingresa tu nueva contraseña institucional.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- PASSWORD -->
            <div class="input-group password-group">
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Nueva contraseña"
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

            <!-- CONFIRM PASSWORD -->
            <div class="input-group password-group">
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Confirmar contraseña"
                       required>

                <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁</span>

                <small id="match-msg"></small>
            </div>

            <button type="submit"
                    id="updateBtn"
                    class="btn-forgot"
                    disabled>
                Actualizar Contraseña
            </button>

        </form>

    </div>

</div>

<script>
const password = document.getElementById('password');
const confirmPass = document.getElementById('password_confirmation');
const strengthFill = document.getElementById('strength-fill');
const strengthText = document.getElementById('strength-text');
const updateBtn = document.getElementById('updateBtn');

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

    if(score <= 2){
        strengthFill.style.width = "33%";
        strengthFill.style.background = "red";
        strengthText.textContent = "Contraseña débil";
    }
    else if(score <=4){
        strengthFill.style.width = "66%";
        strengthFill.style.background = "orange";
        strengthText.textContent = "Contraseña segura";
    }
    else{
        strengthFill.style.width = "100%";
        strengthFill.style.background = "green";
        strengthText.textContent = "Contraseña muy segura";
    }

    validateForm(length, upper, lower, number, special);
}

function toggle(el, condition){
    el.classList.toggle("valid", condition);
}

function validateForm(length, upper, lower, number, special){
    const passwordsMatch = password.value === confirmPass.value;

    document.getElementById('match-msg').textContent =
        passwordsMatch ? "Las contraseñas coinciden" : "No coinciden";

    document.getElementById('match-msg').style.color =
        passwordsMatch ? "green" : "red";

    if(length && upper && lower && number && special && passwordsMatch){
        updateBtn.disabled = false;
    } else {
        updateBtn.disabled = true;
    }
}

password.addEventListener('input', checkPassword);
confirmPass.addEventListener('input', checkPassword);

function togglePassword(id){
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}
</script>

@if(session('reset_success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Contraseña actualizada',
    text: 'Tu contraseña se cambió correctamente.',
    confirmButtonText: 'Iniciar sesión nuevamente',
    confirmButtonColor: '#7b1e3a'
}).then(() => {
    window.location.href = "/login";
});
</script>
@endif

</body>
</html>
