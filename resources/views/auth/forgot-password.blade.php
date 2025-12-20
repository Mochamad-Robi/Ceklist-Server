<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Server Room Checklist</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; }
        
        /* Dark theme with particles */
        .forgot-container {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated grid background */
        .grid-bg {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }
        
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        /* Glowing orbs */
        .glow-orb-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            top: -10%;
            right: -10%;
            animation: float1 8s ease-in-out infinite;
        }
        
        .glow-orb-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -5%;
            left: -5%;
            animation: float2 10s ease-in-out infinite;
        }
        
        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, 30px) scale(1.1); }
        }
        
        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }
        
        /* Glass card effect */
        .glass-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            box-shadow: 
                0 8px 32px 0 rgba(0, 0, 0, 0.37),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }
        
        /* Key icon glow effect */
        .key-icon {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            box-shadow: 
                0 0 60px rgba(99, 102, 241, 0.6),
                0 0 100px rgba(139, 92, 246, 0.4),
                inset 0 0 20px rgba(255, 255, 255, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Input styles */
        .input-field {
            background: rgba(30, 41, 59, 0.6);
            border: 2px solid rgba(99, 102, 241, 0.3);
            color: #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            background: rgba(30, 41, 59, 0.8);
            border-color: #6366f1;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
        }
        
        .input-field::placeholder {
            color: #64748b;
        }
        
        /* Button with shine effect */
        .btn-reset {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-reset::before {
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
        
        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 40px rgba(99, 102, 241, 0.5);
        }
        
        .btn-back {
            background: rgba(30, 41, 59, 0.6);
            border: 2px solid rgba(99, 102, 241, 0.3);
            color: #818cf8;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: #6366f1;
            color: #a5b4fc;
            transform: translateY(-2px);
        }
        
        /* Cyber lines */
        .cyber-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, #6366f1, transparent);
            animation: moveLine 4s linear infinite;
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
        
        /* Label styles */
        .input-label {
            color: #cbd5e1;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }
        
        /* Info box */
        .info-box {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-left: 4px solid #6366f1;
        }
        
        /* Success message */
        .success-box {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-left: 4px solid #22c55e;
        }
    </style>
</head>
<body>
    <div class="forgot-container flex items-center justify-center p-4">
        
        <!-- Animated grid background -->
        <div class="grid-bg"></div>
        
        <!-- Glowing orbs -->
        <div class="glow-orb-1"></div>
        <div class="glow-orb-2"></div>
        
        <!-- Cyber lines -->
        <div class="cyber-line cyber-line-1"></div>
        <div class="cyber-line cyber-line-2"></div>
        
        <div class="w-full max-w-md relative z-10">
            
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <!-- Key Icon -->
                <div class="inline-block mb-6">
                    <div class="key-icon w-20 h-20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-key text-white text-4xl"></i>
                    </div>
                </div>
                
                <h1 class="text-4xl font-bold text-white mb-2" style="text-shadow: 0 0 20px rgba(99, 102, 241, 0.5);">
                    Password Recovery
                </h1>
                <p class="text-slate-400 text-sm font-medium">
                    Reset your account password
                </p>
            </div>
            
            <!-- Forgot Password Card -->
            <div class="glass-card rounded-3xl shadow-2xl p-8">
                
                <!-- Info Message -->
                <div class="info-box rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-indigo-400 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-slate-300 text-sm leading-relaxed">
                                Lupa password Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link reset password yang memungkinkan Anda membuat password baru.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Session Status / Success Message -->
                @if (session('status'))
                    <div class="success-box rounded-xl p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 text-xl mr-3"></i>
                            <span class="text-sm text-green-300 font-medium">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                               class="input-field w-full px-4 py-3 rounded-xl focus:outline-none transition-all"
                               placeholder="user@msk.com">
                        @error('email')
                            <div class="mt-2 flex items-center text-red-400 text-sm">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-3 pt-2">
                        <!-- Reset Button -->
                        <button type="submit" 
                                class="btn-reset w-full text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-all relative">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                SEND RESET LINK
                            </span>
                        </button>
                        
                        <!-- Back to Login -->
                        <a href="{{ route('login') }}" 
                           class="btn-back w-full font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Login
                        </a>
                    </div>
                </form>
                
                <!-- Additional Info -->
                <div class="mt-6 pt-6 border-t border-slate-700">
                    <div class="flex items-center justify-center text-slate-400 text-xs">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Link reset valid selama 60 menit</span>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-slate-500 text-xs">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secured by MSK Security Protocol
                </p>
                <p class="text-slate-600 text-xs mt-2">
                    © {{ date('Y') }} PT Mitra Sendang Kemakmuran. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>