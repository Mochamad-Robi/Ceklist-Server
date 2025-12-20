<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Server Room Checklist</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; }
        
        /* Honda Red theme background */
        .login-container {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 25%, #b91c1c 50%, #dc2626 75%, #991b1b 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated grid background */
        .grid-bg {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }
        
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        /* Glowing orbs - Honda Red */
        .glow-orb-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.4) 0%, transparent 70%);
            border-radius: 50%;
            top: -15%;
            right: -10%;
            animation: float1 8s ease-in-out infinite;
            filter: blur(40px);
        }
        
        .glow-orb-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -10%;
            left: -10%;
            animation: float2 10s ease-in-out infinite;
            filter: blur(40px);
        }
        
        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, 30px) scale(1.1); }
        }
        
        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }
        
        /* Glass card effect with red tint */
        .glass-card {
            background: rgba(127, 29, 29, 0.3);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 8px 32px 0 rgba(0, 0, 0, 0.5),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }
        
        /* Server icon glow effect - Honda Red */
        .server-icon {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            box-shadow: 
                0 0 60px rgba(220, 38, 38, 0.8),
                0 0 100px rgba(239, 68, 68, 0.6),
                inset 0 0 20px rgba(255, 255, 255, 0.3);
            animation: iconPulse 2s ease-in-out infinite;
        }
        
        @keyframes iconPulse {
            0%, 100% { box-shadow: 0 0 60px rgba(220, 38, 38, 0.8), 0 0 100px rgba(239, 68, 68, 0.6), inset 0 0 20px rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 0 80px rgba(220, 38, 38, 1), 0 0 120px rgba(239, 68, 68, 0.8), inset 0 0 30px rgba(255, 255, 255, 0.4); }
        }
        
        /* Input styles with red theme */
        .input-field {
            background: rgba(127, 29, 29, 0.4);
            border: 2px solid rgba(220, 38, 38, 0.4);
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            background: rgba(127, 29, 29, 0.6);
            border-color: #dc2626;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
            transform: translateY(-2px);
        }
        
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        
        /* Button with Honda Red gradient and shine effect */
        .btn-login {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4);
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.3) 50%,
                transparent 70%
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(220, 38, 38, 0.6);
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        }
        
        /* Cyber lines - Red theme */
        .cyber-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, #dc2626, #ef4444, transparent);
            animation: moveLine 4s linear infinite;
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.8);
        }
        
        .cyber-line-1 {
            width: 200px;
            top: 20%;
            left: 0;
        }
        
        .cyber-line-2 {
            width: 150px;
            top: 60%;
            right: 0;
            animation-delay: 2s;
        }
        
        @keyframes moveLine {
            0% { opacity: 0; transform: translateX(-100%); }
            50% { opacity: 1; }
            100% { opacity: 0; transform: translateX(100%); }
        }
        
        /* Label styles with red glow */
        .input-label {
            color: #fff;
            text-shadow: 0 0 10px rgba(220, 38, 38, 0.5);
        }
        
        /* Password toggle with red theme */
        .password-toggle {
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #ef4444;
            transform: scale(1.2);
        }
        
        /* Link styles with red theme */
        .cyber-link {
            color: #fca5a5;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .cyber-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #dc2626, #ef4444);
            transition: width 0.3s ease;
        }
        
        .cyber-link:hover::after {
            width: 100%;
        }
        
        .cyber-link:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(220, 38, 38, 0.8);
        }
        
        /* Captcha Styles with red theme */
        .captcha-container {
            background: rgba(127, 29, 29, 0.4);
            border: 2px solid rgba(220, 38, 38, 0.4);
            border-radius: 12px;
            padding: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .captcha-canvas {
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.6) 0%, rgba(153, 27, 27, 0.6) 100%);
            border-radius: 8px;
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Courier New', monospace;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #fff;
            text-shadow: 
                0 0 10px rgba(220, 38, 38, 0.8),
                0 0 20px rgba(239, 68, 68, 0.6);
            user-select: none;
            position: relative;
            border: 1px solid rgba(220, 38, 38, 0.3);
        }
        
        .captcha-canvas::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(220, 38, 38, 0.1) 2px,
                rgba(220, 38, 38, 0.1) 4px
            );
            pointer-events: none;
        }
        
        .refresh-captcha {
            background: rgba(220, 38, 38, 0.3);
            border: 1px solid rgba(220, 38, 38, 0.5);
            color: #fca5a5;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .refresh-captcha:hover {
            background: rgba(220, 38, 38, 0.5);
            color: #fff;
            transform: rotate(180deg);
            box-shadow: 0 0 15px rgba(220, 38, 38, 0.6);
        }
        
        /* Honda logo inspired pattern */
        .honda-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);
        }
    </style>
</head>
<body>
    <div class="login-container flex items-center justify-center p-4">
        
        <!-- Honda pattern overlay -->
        <div class="honda-pattern"></div>
        
        <!-- Animated grid background -->
        <div class="grid-bg"></div>
        
        <!-- Glowing orbs -->
        <div class="glow-orb-1"></div>
        <div class="glow-orb-2"></div>
        
        <!-- Cyber lines -->
        <div class="cyber-line cyber-line-1"></div>
        <div class="cyber-line cyber-line-2"></div>
        
        <div class="w-full max-w-md relative z-10">  
           <!-- Login Card -->
            <div class="glass-card rounded-3xl shadow-2xl p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">
                        Access Control
                    </h2>
                    <p class="text-red-100 text-sm">Enter your credentials to continue</p>
                </div>

                <div class="text-center mb-8">
        <div class="inline-block mb-6">
            <img src="{{ asset('assets/img/logosamping.png') }}" 
                alt="Logo"
                class="mx-auto h-28 w-auto object-contain">
        </div>
    </div>   
                
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-900 bg-opacity-40 border-2 border-green-400 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-2"></i>
                            <span class="text-sm text-green-200 font-medium">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5" onsubmit="return validateCaptcha()">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="input-label block text-sm font-semibold mb-2">
                            <i class="fas fa-envelope mr-2"></i>
                            Email Address
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="input-field w-full px-4 py-3 rounded-xl focus:outline-none transition-all"
                               placeholder="user@msk.com">
                        @error('email')
                            <div class="mt-2 flex items-center text-red-300 text-sm bg-red-900 bg-opacity-30 p-2 rounded">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="input-label block text-sm font-semibold mb-2">
                            <i class="fas fa-lock mr-2"></i>
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="input-field w-full px-4 py-3 pr-12 rounded-xl focus:outline-none transition-all"
                                   placeholder="••••••••">
                            <button type="button" 
                                    onclick="togglePassword()" 
                                    class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2">
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="mt-2 flex items-center text-red-300 text-sm bg-red-900 bg-opacity-30 p-2 rounded">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div>
                        <label for="captcha" class="input-label block text-sm font-semibold mb-2">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Security Verification
                        </label>
                        <div class="captcha-container">
                            <div class="flex items-center justify-between mb-3">
                                <div class="captcha-canvas flex-1" id="captchaDisplay"></div>
                                <button type="button" 
                                        onclick="generateCaptcha()" 
                                        class="refresh-captcha ml-3"
                                        title="Refresh Captcha">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input id="captcha" 
                               type="text" 
                               name="captcha" 
                               required 
                               class="input-field w-full px-4 py-3 rounded-xl focus:outline-none transition-all mt-3"
                               placeholder="Enter Captcha"
                               autocomplete="off">
                        <div id="captchaError" class="mt-2 hidden flex items-center text-red-300 text-sm bg-red-900 bg-opacity-40 p-2 rounded">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span>Captcha code is incorrect</span>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember_me"
                                   class="w-4 h-4 text-red-600 border-red-400 bg-red-900 bg-opacity-30 rounded focus:ring-2 focus:ring-red-500 cursor-pointer">
                            <span class="ml-2 text-sm text-red-100 group-hover:text-white transition-colors">
                                Remember Me
                            </span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="cyber-link text-sm font-semibold">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            class="btn-login w-full text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-all relative">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            ACCESS SYSTEM
                        </span>
                    </button>
                </form>
            
            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-red-100 text-xs">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secured by MSK Security Protocol
                </p>
                <p class="text-red-200 text-xs mt-2">
                    © {{ date('Y') }} PT Mitra Sendang Kemakmuran. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        let captchaCode = '';
        
        // Generate random captcha
        function generateCaptcha() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            captchaCode = '';
            for (let i = 0; i < 6; i++) {
                captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('captchaDisplay').textContent = captchaCode;
            document.getElementById('captcha').value = '';
            document.getElementById('captchaError').classList.add('hidden');
        }
        
        // Validate captcha
        function validateCaptcha() {
            const userInput = document.getElementById('captcha').value;
            const captchaContainer = document.querySelector('.captcha-container');
            const captchaError = document.getElementById('captchaError');
            
            if (userInput === captchaCode) {
                captchaContainer.classList.remove('error');
                captchaError.classList.add('hidden');
                return true;
            } else {
                // Show error notification
                captchaError.classList.remove('hidden');
                captchaContainer.classList.add('error');
                
                // Show alert
                alert('❌ Kode Captcha Salah!\n\nSilahkan input ulang captcha yang benar.');
                
                // Refresh captcha and clear input
                generateCaptcha();
                
                // Remove error class after animation
                setTimeout(() => {
                    captchaContainer.classList.remove('error');
                }, 500);
                
                return false;
            }
        }
        
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Generate captcha on page load
        window.onload = function() {
            generateCaptcha();
        };
    </script>
</body>
</html>