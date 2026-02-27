<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIPENGADUAN</title>

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

        /* Decorative elements - hidden on mobile */
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

        .login-card {
            width: 100%;
            max-width: 450px;
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
            .login-card {
                max-width: 500px;
            }
        }

        /* Mobile landscape */
        @media (max-width: 767px) and (orientation: landscape) {
            .login-card {
                max-width: 90%;
                margin: 20px auto;
            }
            
            body {
                padding: 8px;
                align-items: flex-start;
            }
        }

        /* Card Light Mode */
        [data-bs-theme="light"] .login-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(79, 172, 254, 0.2);
        }

        /* Card Dark Mode */
        [data-bs-theme="dark"] .login-card {
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

        .login-header {
            border-radius: 24px 24px 0 0;
            padding: clamp(20px, 5vw, 30px);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        /* Header Light Mode */
        [data-bs-theme="light"] .login-header {
            background: linear-gradient(135deg, #4facfe 0%, #00c6ff 100%);
            color: white;
        }

        /* Header Dark Mode */
        [data-bs-theme="dark"] .login-header {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
        }

        .login-header h3 {
            font-size: clamp(20px, 5vw, 28px);
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: clamp(13px, 3vw, 15px);
            margin: 0;
            opacity: 0.9;
        }

        .login-header::before {
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

        .login-body {
            padding: clamp(20px, 4vw, 30px);
        }

        /* Form Labels */
        .form-label {
            font-weight: 500;
            font-size: clamp(13px, 3vw, 14px);
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
            padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 15px);
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

        /* Input Group - ensure proper wrapping on mobile */
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
            padding: clamp(10px, 3vw, 12px) clamp(12px, 3vw, 15px);
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

        /* Login Button */
        .btn-login {
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

        [data-bs-theme="light"] .btn-login {
            background: linear-gradient(135deg, #4facfe 0%, #00c6ff 100%);
            color: white;
        }

        [data-bs-theme="dark"] .btn-login {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* On mobile, disable hover effects */
        @media (max-width: 767px) {
            .btn-login:hover {
                transform: none;
            }
            
            .btn-login:active {
                transform: scale(0.98);
            }
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: clamp(13px, 3vw, 14px);
        }

        [data-bs-theme="light"] .register-link {
            color: #6c757d;
        }

        [data-bs-theme="dark"] .register-link {
            color: #b0b0b0;
        }

        .register-link a {
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-block;
            padding: 5px;
        }

        /* Alert */
        .alert {
            border-radius: 14px;
            border: none;
            margin-bottom: 20px;
            padding: clamp(12px, 3vw, 15px);
            font-size: clamp(13px, 3vw, 14px);
            word-break: break-word;
        }

        /* Checkbox */
        .form-check {
            margin-bottom: 15px;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.15em;
        }

        .form-check-label {
            font-size: clamp(13px, 3vw, 14px);
            padding-left: 5px;
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
                display: none; /* Hide text on very small screens */
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

        .theme-toggle button:hover {
            transform: scale(1.05);
        }

        @media (max-width: 767px) {
            .theme-toggle button:hover {
                transform: none;
            }
            
            .theme-toggle button:active {
                transform: scale(0.95);
            }
        }

        /* Error Message */
        .text-danger {
            font-size: clamp(12px, 2.8vw, 13px);
            margin-top: 5px;
            display: block;
            word-break: break-word;
        }

        /* Input group adjustments for mobile */
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
        }

        /* Landscape mode optimization */
        @media (max-height: 600px) and (orientation: landscape) {
            .login-header {
                padding: 15px;
            }
            
            .login-body {
                padding: 15px;
            }
            
            body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .login-card {
                margin: 5px auto;
            }
        }

        /* Safe area insets for modern phones */
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

<!-- Toggle Theme -->
<div class="theme-toggle">
    <button class="btn" onclick="toggleTheme()" id="themeToggle">
        <i class="bi bi-moon-stars me-2"></i>
        <span id="themeText">Mode Gelap</span>
    </button>
</div>

<div class="login-card">
    <div class="login-header">
        <h3><i class="bi bi-shield-lock me-2"></i>SIPENGADUAN</h3>
        <p class="mb-0">Masuk ke akun Anda</p>
    </div>

    <div class="login-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope me-2"></i>Email
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}"
                           placeholder="Masukkan email Anda"
                           inputmode="email"
                           autocomplete="email"
                           required>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-lock me-2"></i>Password
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Masukkan password Anda"
                           autocomplete="current-password"
                           required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" aria-label="Toggle password visibility">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>

        <div class="register-link">
            Belum punya akun?
            <a href="{{ route('register') }}">
                Daftar sekarang <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// Toggle Theme
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

// Prevent zoom on input focus for iOS
document.addEventListener('touchstart', function(e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
        document.body.style.fontSize = '16px';
    }
}, { passive: true });
</script>

<!-- Bootstrap JS (optional, only if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>