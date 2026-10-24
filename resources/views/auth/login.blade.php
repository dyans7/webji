<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Webji Music - Streaming Audio Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --accent: #ec4899;
            --bg-dark: #090b13;
            --card-bg: rgba(22, 27, 46, 0.75);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(15, 20, 35, 0.6);
            --input-border: rgba(255, 255, 255, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glowing Background Orbs */
        .ambient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.45;
            animation: float 14s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 480px;
            height: 480px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 520px;
            height: 520px;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            bottom: -150px;
            right: -100px;
            animation-duration: 18s;
            animation-direction: alternate-reverse;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: #06b6d4;
            top: 40%;
            left: 55%;
            opacity: 0.25;
            animation-duration: 12s;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(40px) scale(1.08); }
            100% { transform: translateY(-30px) scale(0.95); }
        }

        /* Glassmorphism Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 24px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            padding: 42px 36px;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.65),
                        0 0 0 1px rgba(255, 255, 255, 0.05);
            transition: transform 0.3s ease;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 100px;
            margin-bottom: 16px;
        }

        .brand-badge svg {
            color: #818cf8;
        }

        .brand-badge span {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #c7d2fe;
            text-transform: uppercase;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Quick Demo Hint */
        .demo-hint {
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 24px;
            font-size: 12.5px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .demo-btn {
            background: rgba(99, 102, 241, 0.25);
            border: 1px solid rgba(99, 102, 241, 0.5);
            color: #e0e7ff;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .demo-btn:hover {
            background: #6366f1;
            color: #fff;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 14px;
            color: #fff;
            font-size: 14px;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
            background: rgba(15, 20, 35, 0.85);
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .checkbox-container input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: #818cf8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #a5b4fc;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.45);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(236, 72, 153, 0.45);
            filter: brightness(1.08);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Alert notifications */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .footer-note {
            text-align: center;
            margin-top: 26px;
            font-size: 13px;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Orbs -->
    <div class="ambient-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-header">
                <div class="brand-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13"></path>
                        <circle cx="6" cy="18" r="3"></circle>
                        <circle cx="18" cy="16" r="3"></circle>
                    </svg>
                    <span>Webji Hi-Fi Music</span>
                </div>
                <h1 class="brand-title">Selamat Datang</h1>
                <p class="brand-subtitle">Masuk untuk menikmati pengalaman musik lossless & pemutar audio interaktif.</p>
            </div>

            <!-- Demo Account Auto-Fill Hint -->
            <div class="demo-hint">
                <div>
                    <div><strong>Akun Demo Otomatis:</strong></div>
                    <div style="font-size: 11.5px; color: #94a3b8;">admin@webji.com / password123</div>
                </div>
                <button type="button" class="demo-btn" onclick="fillDemo()">Isi Otomatis</button>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" class="form-input" placeholder="contoh: admin@webji.com" value="{{ old('email', 'admin@webji.com') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" value="password123" required>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" checked>
                        <span>Ingat saya</span>
                    </label>
                    <a href="javascript:void(0)" onclick="fillDemo()" class="forgot-link">Gunakan Demo</a>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Webji Music</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>

            <div class="footer-note">
                Webji Audio Lab &bull; Studio High Fidelity Player
            </div>
        </div>
    </div>

    <script>
        function fillDemo() {
            document.getElementById('email').value = 'admin@webji.com';
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>
