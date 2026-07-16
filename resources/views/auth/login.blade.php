@extends('layouts.app')

@section('content')
<style>
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('{{ asset("assets/img/hero-carousel/hero-carousel-1.jpg") }}') no-repeat center center;
        background-size: cover;
        position: relative;
        overflow: hidden;
    }
    .login-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(13, 25, 66, 0.7);
    }
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        width: 100%;
        max-width: 420px;
        animation: slideUp 0.6s ease-out;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .login-header {
        text-align: center;
        padding: 35px 30px 10px;
    }
    .login-logo {
        width: 200px;
        height: 200px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .login-header h4 {
        color: #1a237e;
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 1.4rem;
    }
    .login-header p {
        color: #666;
        font-size: 0.9rem;
    }
    .login-body {
        padding: 20px 30px 30px;
    }
    .form-floating {
        position: relative;
        margin-bottom: 18px;
    }
    .form-floating input {
        width: 100%;
        padding: 14px 45px 14px 45px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    .form-floating input:focus {
        border-color: #1a237e;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(26, 35, 126, 0.1);
        outline: none;
    }
    .form-floating label {
        position: absolute;
        left: 45px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 0.9rem;
        pointer-events: none;
        transition: all 0.3s ease;
        background: transparent;
        padding: 0 5px;
    }
    .form-floating input:focus + label,
    .form-floating input:not(:placeholder-shown) + label {
        top: -8px;
        left: 35px;
        font-size: 0.75rem;
        color: #1a237e;
        background: #fff;
        padding: 0 5px;
    }
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 1.1rem;
        transition: color 0.3s;
        z-index: 2;
    }
    .form-floating input:focus ~ .input-icon {
        color: #1a237e;
    }
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 5px;
        z-index: 2;
        transition: color 0.3s;
    }
    .toggle-password:hover {
        color: #1a237e;
    }
    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .remember-row label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #666;
        cursor: pointer;
    }
    .remember-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #1a237e;
        cursor: pointer;
    }
    .btn-login {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #1a237e, #0d47a1);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(26, 35, 126, 0.4);
    }
    .btn-login:active {
        transform: translateY(0);
    }
    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    .btn-login .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    .btn-login.loading .btn-text { display: none; }
    .btn-login.loading .spinner { display: block; }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .alert-error {
        background: #fff3f3;
        border: 1px solid #ffcdd2;
        color: #c62828;
        padding: 12px 15px;
        border-radius: 10px;
        font-size: 0.85rem;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: shake 0.5s ease;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }
    .alert-error i {
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .login-footer {
        text-align: center;
        padding: 0 30px 25px;
    }
    .login-footer p {
        font-size: 0.8rem;
        color: #999;
    }
    .church-name {
        color: #1a237e;
        font-weight: 600;
    }
</style>

<div class="login-page">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            </div>
            <h4>Selamat Datang</h4>
            <p>Masuk ke panel admin</p>
        </div>

        <div class="login-body">
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form role="form" method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                @method('post')

                <div class="form-floating">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required autofocus>
                    <label for="email">Email</label>
                </div>

                <div class="form-floating">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" placeholder=" " required>
                    <label for="password">Password</label>
                    <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="remember-row">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <span class="btn-text">Masuk</span>
                    <div class="spinner"></div>
                </button>
            </form>
        </div>

        <div class="login-footer">
            <p>&copy; {{ date('Y') }} <span class="church-name">{{ $identitas->nama_website ?? 'GKI Maleo Raya' }}</span></p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('btnLogin');
    btn.classList.add('loading');
    btn.disabled = true;
});
</script>
@endsection
