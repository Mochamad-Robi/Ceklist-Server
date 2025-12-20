@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 py-12 px-4">
    <div class="container mx-auto">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header Section dengan Floating Effect -->
            <div class="text-center mb-12 animate-fade-in">
                <div class="inline-block mb-4">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-full p-4 shadow-2xl">
                        <i class="fas fa-user-cog text-white text-5xl"></i>
                    </div>
                </div>
                <h1 class="text-5xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    Pengaturan Profil
                </h1>
                <p class="text-gray-600 text-lg font-medium">Kelola informasi pribadi dan keamanan akun Anda dengan mudah</p>
            </div>

            <!-- Success Notifications -->
            @if (session('status') === 'profile-updated')
                <div class="mb-8 max-w-3xl mx-auto">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-5 rounded-2xl shadow-2xl animate-bounce-in flex items-center">
                        <div class="bg-white rounded-full p-3 mr-4">
                            <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Berhasil!</h3>
                            <p class="text-green-50">Profil Anda telah diperbarui dengan sukses</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-8 max-w-3xl mx-auto">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-5 rounded-2xl shadow-2xl animate-bounce-in flex items-center">
                        <div class="bg-white rounded-full p-3 mr-4">
                            <i class="fas fa-shield-check text-purple-500 text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Password Diperbarui!</h3>
                            <p class="text-purple-50">Password akun Anda berhasil diubah</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status') === 'photo-updated')
                <div class="mb-8 max-w-3xl mx-auto">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white p-5 rounded-2xl shadow-2xl animate-bounce-in flex items-center">
                        <div class="bg-white rounded-full p-3 mr-4">
                            <i class="fas fa-camera text-blue-500 text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Foto Diperbarui!</h3>
                            <p class="text-blue-50">Foto profil Anda berhasil diubah</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Sidebar - Profile Card (Lebih Compact) -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden sticky top-8 border border-gray-100">
                        
                        <!-- Profile Header with Gradient Background -->
                        <div class="relative bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 p-8 pb-20">
                            <!-- Decorative Circles -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>
                            
                            <!-- Role Badge -->
                            <div class="absolute top-6 right-6">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black shadow-lg
                                    {{ $user->role === 'admin' ? 'bg-gradient-to-r from-yellow-400 to-orange-400 text-orange-900' : 'bg-gradient-to-r from-blue-400 to-cyan-400 text-blue-900' }}">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }} mr-2"></i>
                                    {{ strtoupper($user->role) }}
                                </span>
                            </div>
                        </div>

                        <!-- Profile Photo Upload (Overlap) -->
                        <div class="relative -mt-16 mb-4">
                            <form id="photoForm" action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                
                                <div class="relative inline-block group mx-auto" style="display: block; text-align: center;">
                                    <div class="w-32 h-32 mx-auto rounded-3xl border-4 border-white shadow-2xl overflow-hidden bg-white transform transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-500">
                                                <span class="text-white text-5xl font-black">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Upload Overlay -->
                                    <label for="photo" class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-black to-purple-900 bg-opacity-0 group-hover:bg-opacity-75 rounded-3xl cursor-pointer transition-all duration-300">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                                            <i class="fas fa-camera text-white text-3xl mb-2"></i>
                                            <p class="text-white text-xs font-semibold">Upload Foto</p>
                                        </div>
                                    </label>
                                    
                                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('photoForm').submit()">
                                    
                                    <!-- Camera Icon Badge -->
                                    <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full p-3 shadow-xl border-4 border-white group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-camera text-white text-sm"></i>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- User Info -->
                        <div class="text-center px-8 pb-6">
                            <h2 class="text-2xl font-black text-gray-800 mb-1">{{ $user->name }}</h2>
                            <p class="text-gray-500 text-sm font-medium mb-4">{{ $user->email }}</p>
                        </div>

                        <!-- Stats Cards -->
                        <div class="px-6 pb-8 space-y-3">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-2xl border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-blue-500 rounded-xl p-2 mr-3">
                                            <i class="fas fa-calendar-alt text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-semibold">Bergabung Sejak</p>
                                            <p class="text-sm font-bold text-blue-900">{{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-2xl border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-purple-500 rounded-xl p-2 mr-3">
                                            <i class="fas fa-sync-alt text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-purple-600 font-semibold">Terakhir Update</p>
                                            <p class="text-sm font-bold text-purple-900">{{ $user->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-green-50 to-emerald-100 p-4 rounded-2xl border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-green-500 rounded-xl p-2 mr-3">
                                            <i class="fas fa-shield-check text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-green-600 font-semibold">Status Akun</p>
                                            <p class="text-sm font-bold text-green-900">Aktif & Terverifikasi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Forms -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Profile Information Form -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 transform hover:scale-[1.01] transition-all duration-300">
                        <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 px-8 py-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                            <div class="relative z-10">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-3 mr-4">
                                        <i class="fas fa-user-edit text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-white font-black text-2xl">Informasi Profil</h2>
                                        <p class="text-blue-100 text-sm font-medium">Update nama dan email akun Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" class="p-8 space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Name Field -->
                            <div class="group">
                                <label for="name" class="block text-sm font-black text-gray-700 mb-3 flex items-center">
                                    <div class="bg-blue-100 rounded-xl p-2 mr-2">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        class="w-full px-6 py-5 border-3 border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 font-semibold text-gray-800 bg-gray-50 hover:bg-white @error('name') border-red-500 @enderror"
                                        placeholder="Contoh: John Doe"
                                    >
                                    <div class="absolute right-5 top-5 text-gray-400">
                                        <i class="fas fa-user-circle text-xl"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <div class="mt-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-shake">
                                        <p class="text-sm text-red-700 font-semibold flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="group">
                                <label for="email" class="block text-sm font-black text-gray-700 mb-3 flex items-center">
                                    <div class="bg-blue-100 rounded-xl p-2 mr-2">
                                        <i class="fas fa-envelope text-blue-600 text-sm"></i>
                                    </div>
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full px-6 py-5 border-3 border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 font-semibold text-gray-800 bg-gray-50 hover:bg-white @error('email') border-red-500 @enderror"
                                        placeholder="nama@example.com"
                                    >
                                    <div class="absolute right-5 top-5 text-gray-400">
                                        <i class="fas fa-envelope text-xl"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="mt-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-shake">
                                        <p class="text-sm text-red-700 font-semibold flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button 
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 text-white px-8 py-5 rounded-2xl font-black text-lg hover:from-blue-700 hover:via-blue-800 hover:to-purple-700 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-2xl hover:shadow-3xl flex items-center justify-center group">
                                    <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                                    Simpan Perubahan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Update Password Form -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 transform hover:scale-[1.01] transition-all duration-300">
                        <div class="bg-gradient-to-r from-purple-500 via-purple-600 to-pink-600 px-8 py-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                            <div class="relative z-10">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-3 mr-4">
                                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-white font-black text-2xl">Keamanan Password</h2>
                                        <p class="text-purple-100 text-sm font-medium">Gunakan password yang kuat untuk melindungi akun</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('profile.password.update') }}" class="p-8 space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div class="group">
                                <label for="current_password" class="block text-sm font-black text-gray-700 mb-3 flex items-center">
                                    <div class="bg-purple-100 rounded-xl p-2 mr-2">
                                        <i class="fas fa-key text-purple-600 text-sm"></i>
                                    </div>
                                    Password Saat Ini
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="current_password" 
                                        name="current_password"
                                        class="w-full px-6 py-5 border-3 border-gray-200 rounded-2xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 font-semibold text-gray-800 bg-gray-50 hover:bg-white @error('current_password', 'updatePassword') border-red-500 @enderror"
                                        placeholder="••••••••"
                                    >
                                    <div class="absolute right-5 top-5 text-gray-400">
                                        <i class="fas fa-lock text-xl"></i>
                                    </div>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <div class="mt-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-shake">
                                        <p class="text-sm text-red-700 font-semibold flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="group">
                                <label for="password" class="block text-sm font-black text-gray-700 mb-3 flex items-center">
                                    <div class="bg-purple-100 rounded-xl p-2 mr-2">
                                        <i class="fas fa-lock text-purple-600 text-sm"></i>
                                    </div>
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password"
                                        class="w-full px-6 py-5 border-3 border-gray-200 rounded-2xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 font-semibold text-gray-800 bg-gray-50 hover:bg-white @error('password', 'updatePassword') border-red-500 @enderror"
                                        placeholder="••••••••"
                                    >
                                    <div class="absolute right-5 top-5 text-gray-400">
                                        <i class="fas fa-shield-alt text-xl"></i>
                                    </div>
                                </div>
                                @error('password', 'updatePassword')
                                    <div class="mt-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-shake">
                                        <p class="text-sm text-red-700 font-semibold flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                        </p>
                                    </div>
                                @enderror
                                <div class="mt-3 bg-purple-50 border-l-4 border-purple-300 p-4 rounded-lg">
                                    <p class="text-xs text-purple-700 font-semibold flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>Password minimal 8 karakter, kombinasi huruf dan angka
                                    </p>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="group">
                                <label for="password_confirmation" class="block text-sm font-black text-gray-700 mb-3 flex items-center">
                                    <div class="bg-purple-100 rounded-xl p-2 mr-2">
                                        <i class="fas fa-check-circle text-purple-600 text-sm"></i>
                                    </div>
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password_confirmation" 
                                        name="password_confirmation"
                                        class="w-full px-6 py-5 border-3 border-gray-200 rounded-2xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 font-semibold text-gray-800 bg-gray-50 hover:bg-white"
                                        placeholder="••••••••"
                                    >
                                    <div class="absolute right-5 top-5 text-gray-400">
                                        <i class="fas fa-check-double text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button 
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 text-white px-8 py-5 rounded-2xl font-black text-lg hover:from-purple-700 hover:via-purple-800 hover:to-pink-700 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-2xl hover:shadow-3xl flex items-center justify-center group">
                                    <i class="fas fa-shield-check mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                                    Update Password Sekarang
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Back Button dengan Style Baru -->
                    <div class="text-center">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-10 py-4 text-gray-700 bg-white hover:bg-gray-50 rounded-2xl font-black transition-all duration-300 shadow-xl hover:shadow-2xl border-2 border-gray-200 hover:border-gray-300 group">
                            <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-2 transition-transform duration-300"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Advanced Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce-in {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }
    50% {
        box-shadow: 0 0 40px rgba(99, 102, 241, 0.8);
    }
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out;
}

.animate-bounce-in {
    animation: bounce-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.animate-shake {
    animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97);
}

/* Custom Shadows */
.shadow-3xl {
    box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
}

/* Smooth Border Width */
.border-3 {
    border-width: 3px;
}

/* Hover Effects */
input:hover {
    transform: translateY(-2px);
}

button:hover {
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
}
</style>
@endsection