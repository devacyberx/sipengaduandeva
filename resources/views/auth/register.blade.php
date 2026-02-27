<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - SIPENGADUAN</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            transition: background 0.4s ease;
            margin: 0;
            position: relative;
        }

        /* Light Mode Background */
        [data-bs-theme="light"] body {
            background: linear-gradient(135deg, #4facfe 0%, #00c6ff 100%);
        }

        /* Dark Mode Background */
        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        /* Decorative elements */
        body::before {
            content: '';
            position: fixed;
            width: min(400px, 80vw);
            height: min(400px, 80vw);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 0;
            transition: background 0.4s ease;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: min(300px, 60vw);
            height: min(300px, 60vw);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            z-index: 0;
            transition: background 0.4s ease;
            pointer-events: none;
        }

        [data-bs-theme="light"] body::before {
            background: rgba(255, 255, 255, 0.3);
        }

        [data-bs-theme="light"] body::after {
            background: rgba(0, 198, 255, 0.2);
        }

        [data-bs-theme="dark"] body::before {
            background: rgba(0, 255, 255, 0.1);
        }

        [data-bs-theme="dark"] body::after {
            background: rgba(0, 255, 255, 0.05);
        }

        .register-card {
            width: 100%;
            max-width: 550px;
            border-radius: 24px;
            border: none;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease-out;
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
            overflow: hidden;
            margin: 0 auto;
        }

        /* Tablet styles */
        @media (min-width: 768px) and (max-width: 991px) {
            .register-card {
                max-width: 600px;
            }
        }

        /* Mobile landscape */
        @media (max-width: 767px) and (orientation: landscape) {
            .register-card {
                max-width: 95%;
                margin: 15px auto;
            }
            
            body {
                padding: 8px;
                align-items: flex-start;
            }
        }

        /* Card Light Mode */
        [data-bs-theme="light"] .register-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(79, 172, 254, 0.2);
        }

        /* Card Dark Mode */
        [data-bs-theme="dark"] .register-card {
            background: rgba(26, 26, 46, 0.98);
            border: 1px solid rgba(0, 255, 255, 0.1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            border-radius: 24px 24px 0 0;
            padding: clamp(20px, 5vw, 30px);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        /* Header Light Mode */
        [data-bs-theme="light"] .register-header {
            background: linear-gradient(135deg, #4facfe 0%, #00c6ff 100%);
            color: white;
        }

        /* Header Dark Mode */
        [data-bs-theme="dark"] .register-header {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
        }

        .register-header h1 {
            font-size: clamp(22px, 6vw, 28px);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-header p {
            font-size: clamp(13px, 3.5vw, 15px);
            margin: 8px 0 0;
            opacity: 0.9;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .register-body {
            padding: clamp(20px, 4vw, 30px);
        }

        /* Form Labels */
        .form-label {
            font-weight: 500;
            font-size: clamp(13px, 3.5vw, 14px);
            margin-bottom: 6px;
        }

        [data-bs-theme="light"] .form-label {
            color: #2c3e50;
        }

        [data-bs-theme="dark"] .form-label {
            color: #e0e0e0;
        }

        /* Form Controls */
        .form-control, .input-group-text {
            border-radius: 14px;
            padding: clamp(10px, 3vw, 12px) clamp(12px, 3.5vw, 15px);
            font-size: clamp(14px, 3.5vw, 15px);
            transition: all 0.3s ease;
            height: auto;
        }

        /* Light Mode Form Controls */
        [data-bs-theme="light"] .form-control {
            background-color: white;
            border: 2px solid #e0e0e0;
            color: #333;
        }

        [data-bs-theme="light"] .form-control:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        }

        [data-bs-theme="light"] .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e0e0e0;
            color: #4facfe;
        }

        /* Dark Mode Form Controls */
        [data-bs-theme="dark"] .form-control {
            background-color: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(0, 255, 255, 0.2);
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .form-control:focus {
            border-color: #00d2ff;
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
            background-color: rgba(0, 0, 0, 0.4);
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
            font-size: clamp(13px, 3vw, 14px);
        }

        [data-bs-theme="dark"] .input-group-text {
            background-color: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(0, 255, 255, 0.2);
            color: #00d2ff;
        }

        /* Input Group */
        .input-group {
            flex-wrap: nowrap;
        }

        .input-group > .form-control {
            min-width: 0;
            flex: 1 1 auto;
        }

        /* Password Toggle Button */
        .btn-outline-secondary {
            border-radius: 14px;
            padding: clamp(10px, 3vw, 12px) clamp(12px, 3.5vw, 15px);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        [data-bs-theme="light"] .btn-outline-secondary {
            border: 2px solid #e0e0e0;
            color: #4facfe;
            background-color: #f8f9fa;
        }

        [data-bs-theme="light"] .btn-outline-secondary:hover {
            background-color: #4facfe;
            border-color: #4facfe;
            color: white;
        }

        [data-bs-theme="dark"] .btn-outline-secondary {
            border: 2px solid rgba(0, 255, 255, 0.2);
            color: #00d2ff;
            background-color: rgba(0, 0, 0, 0.4);
        }

        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: #00d2ff;
            border-color: #00d2ff;
            color: #1a1a2e;
        }

        /* Register Button */
        .btn-register {
            border-radius: 14px;
            padding: clamp(12px, 4vw, 14px);
            font-weight: 600;
            font-size: clamp(15px, 4vw, 16px);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        [data-bs-theme="light"] .btn-register {
            background: linear-gradient(135deg, #4facfe 0%, #00c6ff 100%);
            color: white;
        }

        [data-bs-theme="dark"] .btn-register {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 767px) {
            .btn-register:hover {
                transform: none;
            }
            
            .btn-register:active {
                transform: scale(0.98);
            }
        }

        /* Password Strength */
        .password-strength {
            height: 5px;
            border-radius: 10px;
            margin-top: 10px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        [data-bs-theme="light"] .password-strength {
            background: #e0e0e0;
        }

        [data-bs-theme="dark"] .password-strength {
            background: rgba(255, 255, 255, 0.1);
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: #dc3545;
            width: 25%;
        }

        .strength-medium {
            background: #ffc107;
            width: 50%;
        }

        .strength-strong {
            background: #28a745;
            width: 75%;
        }

        .strength-very-strong {
            background: #20c997;
            width: 100%;
        }

        /* Password Requirements */
        .password-requirements {
            margin-top: 10px;
        }

        .password-hint {
            font-size: clamp(11px, 3vw, 12px);
            margin-top: 5px;
            word-break: break-word;
        }

        [data-bs-theme="light"] .password-hint {
            color: #6c757d;
        }

        [data-bs-theme="dark"] .password-hint {
            color: #b0b0b0;
        }

        .password-hint i {
            margin-right: 5px;
            width: 16px;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid;
            font-size: clamp(13px, 3.5vw, 14px);
        }

        [data-bs-theme="light"] .login-link {
            border-top-color: #e0e0e0;
        }

        [data-bs-theme="dark"] .login-link {
            border-top-color: rgba(0, 255, 255, 0.1);
        }

        .login-link p {
            margin-bottom: 0;
        }

        [data-bs-theme="light"] .login-link p {
            color: #6c757d;
        }

        [data-bs-theme="dark"] .login-link p {
            color: #b0b0b0;
        }

        .login-link a {
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-block;
            padding: 5px;
        }

        /* Terms Check */
        .terms-check {
            margin: 20px 0;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.15em;
        }

        .form-check-label {
            font-size: clamp(13px, 3.5vw, 14px);
            padding-left: 5px;
        }

        .form-check-label a {
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .form-check-label a {
                white-space: normal;
            }
            
            .form-check-label {
                line-height: 1.4;
            }
        }

        /* Alert */
        .alert {
            border-radius: 14px;
            padding: clamp(12px, 3vw, 15px);
            margin-bottom: 20px;
            font-size: clamp(13px, 3.5vw, 14px);
            word-break: break-word;
        }

        .alert ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        /* Invalid Feedback */
        .invalid-feedback {
            font-size: clamp(11px, 3vw, 12px);
            margin-top: 5px;
            display: block;
        }

        /* Email Status */
        #emailStatus {
            font-size: clamp(11px, 3vw, 12px);
            margin-top: 5px;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            top: max(10px, env(safe-area-inset-top));
            right: max(10px, env(safe-area-inset-right));
            z-index: 1000;
        }

        .theme-toggle button {
            border-radius: 30px;
            padding: 8px 16px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-weight: 500;
            font-size: clamp(13px, 3vw, 14px);
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .theme-toggle button span {
                display: none;
            }
            
            .theme-toggle button i {
                margin-right: 0 !important;
                font-size: 18px;
            }
            
            .theme-toggle button {
                padding: 8px 12px;
                border-radius: 40px;
            }
        }

        [data-bs-theme="light"] .theme-toggle button {
            background: linear-gradient(135deg, #4facfe, #00c6ff);
            color: white;
        }

        [data-bs-theme="dark"] .theme-toggle button {
            background: rgba(26, 26, 46, 0.9);
            color: #00d2ff;
            border: 1px solid rgba(0, 255, 255, 0.2);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 24px;
            border: none;
        }

        [data-bs-theme="light"] .modal-content {
            background: white;
        }

        [data-bs-theme="dark"] .modal-content {
            background: #1a1a2e;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer {
            border-color: rgba(0, 255, 255, 0.1);
        }

        [data-bs-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .modal-body {
            padding: clamp(15px, 4vw, 20px);
            font-size: clamp(13px, 3.5vw, 14px);
        }

        .modal-body h6 {
            font-size: clamp(14px, 4vw, 16px);
            margin-top: 15px;
        }

        .modal-body h6:first-child {
            margin-top: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .input-group-text {
                padding: 10px 8px;
            }
            
            .input-group-text i {
                font-size: 14px;
            }
            
            .btn-outline-secondary {
                padding: 10px 8px;
            }
            
            .password-hint i {
                width: 14px;
            }
        }

        /* Landscape mode */
        @media (max-height: 600px) and (orientation: landscape) {
            .register-header {
                padding: 15px;
            }
            
            .register-body {
                padding: 15px;
            }
            
            body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .register-card {
                margin: 5px auto;
            }
        }

        /* Safe area insets */
        @supports (padding: max(0px)) {
            body {
                padding-left: max(16px, env(safe-area-inset-left));
                padding-right: max(16px, env(safe-area-inset-right));
                padding-top: max(16px, env(safe-area-inset-top));
                padding-bottom: max(16px, env(safe-area-inset-bottom));
            }
            
            .theme-toggle {
                top: max(10px, env(safe-area-inset-top));
                right: max(10px, env(safe-area-inset-right));
            }
        }
    </style>
</head>
<body>

<!-- Theme Toggle -->
<div class="theme-toggle">
    <button class="btn" onclick="toggleTheme()" id="themeToggle">
        <i class="bi bi-moon-stars me-2"></i>
        <span id="themeText">Mode Gelap</span>
    </button>
</div>

<!-- Register Card -->
<div class="register-card">
    <div class="register-header">
        <h1><i class="bi bi-shield-check me-2"></i>SIPENGADUAN</h1>
        <p>Daftar Akun Siswa Baru</p>
    </div>

    <div class="register-body">
        <!-- Alert Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-person me-1"></i>Nama Lengkap
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Masukkan nama lengkap"
                           inputmode="text"
                           autocomplete="name"
                           required 
                           autofocus>
                </div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i>Email
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="contoh@email.com"
                           inputmode="email"
                           autocomplete="email"
                           required>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="emailStatus" class="mt-1 small"></div>
            </div>

            <!-- Kelas -->
            <div class="mb-3">
                <label for="class" class="form-label">
                    <i class="bi bi-building me-1"></i>Kelas
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-building"></i>
                    </span>
                    <input type="text" 
                           class="form-control @error('class') is-invalid @enderror" 
                           id="class" 
                           name="class" 
                           value="{{ old('class') }}" 
                           placeholder="Contoh: XII RPL 1"
                           inputmode="text"
                           autocomplete="off"
                           required>
                </div>
                @error('class')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="phone" class="form-label">
                    <i class="bi bi-telephone me-1"></i>Nomor Telepon (Opsional)
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-telephone"></i>
                    </span>
                    <input type="tel" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="081234567890"
                           inputmode="numeric"
                           autocomplete="tel">
                </div>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Minimal 8 karakter"
                           autocomplete="new-password"
                           required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <!-- Password Strength -->
                <div class="password-strength mt-2">
                    <div class="password-strength-bar" id="passwordStrength"></div>
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements mt-2">
                    <div class="password-hint" id="lengthCheck">
                        <i class="bi bi-x-circle text-danger"></i> Minimal 8 karakter
                    </div>
                    <div class="password-hint" id="uppercaseCheck">
                        <i class="bi bi-x-circle text-danger"></i> Huruf besar (A-Z)
                    </div>
                    <div class="password-hint" id="lowercaseCheck">
                        <i class="bi bi-x-circle text-danger"></i> Huruf kecil (a-z)
                    </div>
                    <div class="password-hint" id="numberCheck">
                        <i class="bi bi-x-circle text-danger"></i> Angka (0-9)
                    </div>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Ulangi password"
                           autocomplete="new-password"
                           required>
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" aria-label="Toggle confirm password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div id="passwordMatch" class="mt-1 small"></div>
            </div>

            <!-- Terms and Conditions -->
            <div class="terms-check">
                <div class="form-check">
                    <input class="form-check-input @error('terms') is-invalid @enderror" 
                           type="checkbox" 
                           id="terms" 
                           name="terms" 
                           {{ old('terms') ? 'checked' : '' }}
                           required>
                    <label class="form-check-label" for="terms">
                        Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat dan Ketentuan</a> serta <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Kebijakan Privasi</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn btn-register" id="registerBtn">
                <i class="bi bi-person-plus me-2"></i>
                Daftar Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            <p class="mb-0">
                Sudah punya akun? 
                <a href="{{ route('login') }}">
                    Login di sini <i class="bi bi-arrow-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Ketentuan Umum</h6>
                <p>Dengan mendaftar, Anda menyetujui untuk menggunakan sistem SIPENGADUAN sesuai dengan peraturan yang berlaku.</p>

                <h6>2. Pengaduan</h6>
                <p>Setiap pengaduan harus disertai dengan informasi yang benar dan jelas. Pengaduan palsu akan dikenakan sanksi.</p>

                <h6>3. Privasi</h6>
                <p>Data pribadi Anda akan dilindungi dan hanya digunakan untuk keperluan sistem pengaduan.</p>

                <h6>4. Tanggung Jawab</h6>
                <p>Pengguna bertanggung jawab penuh atas setiap pengaduan yang dibuat melalui akunnya.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Kebijakan Privasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Pengumpulan Data</h6>
                <p>Kami mengumpulkan data seperti nama, email, kelas, dan nomor telepon untuk keperluan identifikasi dan komunikasi terkait pengaduan.</p>

                <h6>Penggunaan Data</h6>
                <p>Data Anda digunakan untuk memproses pengaduan, memberikan notifikasi, dan keperluan statistik internal.</p>

                <h6>Keamanan Data</h6>
                <p>Kami menjaga keamanan data Anda dengan sistem enkripsi dan akses terbatas.</p>

                <h6>Hak Pengguna</h6>
                <p>Anda berhak untuk mengakses, mengubah, atau menghapus data pribadi Anda kapan saja.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Theme Toggle
function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-bs-theme');
    const newTheme = current === 'dark' ? 'light' : 'dark';
    const themeToggle = document.getElementById('themeToggle');
    const themeText = document.getElementById('themeText');
    const icon = themeToggle.querySelector('i');
    
    html.setAttribute('data-bs-theme', newTheme);
    
    // Update button text and icon
    if (newTheme === 'dark') {
        themeText.textContent = 'Mode Terang';
        icon.classList.remove('bi-moon-stars');
        icon.classList.add('bi-sun');
    } else {
        themeText.textContent = 'Mode Gelap';
        icon.classList.remove('bi-sun');
        icon.classList.add('bi-moon-stars');
    }
    
    // Save to localStorage
    try {
        localStorage.setItem('theme', newTheme);
    } catch (e) {
        console.log('localStorage not available');
    }
}

// Load saved theme
document.addEventListener('DOMContentLoaded', function() {
    try {
        const savedTheme = localStorage.getItem('theme') || 'light';
        const html = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeText = document.getElementById('themeText');
        const icon = themeToggle.querySelector('i');
        
        html.setAttribute('data-bs-theme', savedTheme);
        
        // Update button text and icon based on saved theme
        if (savedTheme === 'dark') {
            themeText.textContent = 'Mode Terang';
            icon.classList.remove('bi-moon-stars');
            icon.classList.add('bi-sun');
        } else {
            themeText.textContent = 'Mode Gelap';
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon-stars');
        }
    } catch (e) {
        console.log('Error loading theme');
    }
});

// Toggle Password Visibility
document.getElementById('togglePassword')?.addEventListener('click', function() {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    const icon = this.querySelector('i');
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
});

document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
    const password = document.getElementById('password_confirmation');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    const icon = this.querySelector('i');
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
});

// Password Strength Checker
const password = document.getElementById('password');
if (password) {
    const strengthBar = document.getElementById('passwordStrength');
    const lengthCheck = document.getElementById('lengthCheck');
    const uppercaseCheck = document.getElementById('uppercaseCheck');
    const lowercaseCheck = document.getElementById('lowercaseCheck');
    const numberCheck = document.getElementById('numberCheck');

    password.addEventListener('input', function() {
        const value = this.value;
        let strength = 0;
        
        // Length check
        if (value.length >= 8) {
            lengthCheck.innerHTML = '<i class="bi bi-check-circle text-success"></i> Minimal 8 karakter ✓';
            strength++;
        } else {
            lengthCheck.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Minimal 8 karakter';
        }
        
        // Uppercase check
        if (/[A-Z]/.test(value)) {
            uppercaseCheck.innerHTML = '<i class="bi bi-check-circle text-success"></i> Huruf besar (A-Z) ✓';
            strength++;
        } else {
            uppercaseCheck.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Huruf besar (A-Z)';
        }
        
        // Lowercase check
        if (/[a-z]/.test(value)) {
            lowercaseCheck.innerHTML = '<i class="bi bi-check-circle text-success"></i> Huruf kecil (a-z) ✓';
            strength++;
        } else {
            lowercaseCheck.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Huruf kecil (a-z)';
        }
        
        // Number check
        if (/[0-9]/.test(value)) {
            numberCheck.innerHTML = '<i class="bi bi-check-circle text-success"></i> Angka (0-9) ✓';
            strength++;
        } else {
            numberCheck.innerHTML = '<i class="bi bi-x-circle text-danger"></i> Angka (0-9)';
        }
        
        // Update strength bar
        if (strengthBar) {
            strengthBar.className = 'password-strength-bar';
            if (value.length === 0) {
                strengthBar.style.width = '0%';
            } else if (strength <= 1) {
                strengthBar.classList.add('strength-weak');
            } else if (strength === 2) {
                strengthBar.classList.add('strength-medium');
            } else if (strength === 3) {
                strengthBar.classList.add('strength-strong');
            } else if (strength === 4) {
                strengthBar.classList.add('strength-very-strong');
            }
        }
    });
}

// Password match checker
const confirmPassword = document.getElementById('password_confirmation');
const passwordMatch = document.getElementById('passwordMatch');

function checkPasswordMatch() {
    if (confirmPassword && password && passwordMatch) {
        if (confirmPassword.value.length > 0) {
            if (password.value === confirmPassword.value) {
                passwordMatch.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Password cocok</span>';
            } else {
                passwordMatch.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> Password tidak cocok</span>';
            }
        } else {
            passwordMatch.innerHTML = '';
        }
    }
}

if (password && confirmPassword) {
    password.addEventListener('input', checkPasswordMatch);
    confirmPassword.addEventListener('input', checkPasswordMatch);
}

// Email availability check (AJAX)
const email = document.getElementById('email');
const emailStatus = document.getElementById('emailStatus');
let timeout = null;

if (email && emailStatus) {
    email.addEventListener('input', function() {
        clearTimeout(timeout);
        const value = this.value;
        
        if (value.length > 5 && value.includes('@') && value.includes('.')) {
            emailStatus.innerHTML = '<span class="text-info"><i class="bi bi-hourglass"></i> Memeriksa ketersediaan...</span>';
            
            timeout = setTimeout(() => {
                // Simulate AJAX call - replace with actual endpoint
                fetch('/check-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ email: value })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        emailStatus.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> Email sudah terdaftar</span>';
                    } else {
                        emailStatus.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Email tersedia</span>';
                    }
                })
                .catch(error => {
                    emailStatus.innerHTML = '';
                });
            }, 500);
        } else {
            emailStatus.innerHTML = '';
        }
    });
}

// Form validation before submit
document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    const terms = document.getElementById('terms');
    
    if (!terms || !terms.checked) {
        e.preventDefault();
        alert('Anda harus menyetujui Syarat dan Ketentuan');
        return false;
    }
    
    if (password && confirmPassword && password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok');
        return false;
    }
    
    if (password && password.value.length < 8) {
        e.preventDefault();
        alert('Password minimal 8 karakter');
        return false;
    }
    
    // Disable button to prevent double submission
    const btn = document.getElementById('registerBtn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mendaftar...';
    }
});

// Prevent zoom on input focus for iOS
document.addEventListener('touchstart', function(e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
        document.body.style.fontSize = '16px';
    }
}, { passive: true });

// Handle orientation change
window.addEventListener('orientationchange', function() {
    setTimeout(function() {
        document.body.style.height = window.innerHeight + 'px';
    }, 100);
});
</script>

</body>
</html>