<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Server Room Checklist')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #fee2e2;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #dc2626;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #b91c1c;
        }
        
        /* Sidebar active state */
        .sidebar-link.active {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
        
        .sidebar-link.active i {
            color: white;
        }
        
        /* Hover effects */
        .sidebar-link:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            transform: translateX(4px);
        }
        
        .sidebar-link:hover i {
            color: white;
        }
        
        /* Smooth transitions */
        .sidebar-link {
            transition: all 0.3s ease;
        }
        
        /* Honda Red Gradient */
        .honda-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }
        
        /* Honda accent */
        .honda-accent {
            background: linear-gradient(to right, #dc2626, #b91c1c);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: true }">
    
    <!-- Top Navbar -->
    <nav class="honda-gradient shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 rounded-lg hover:bg-red-700 text-white transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white p-2 rounded-lg shadow-md">
                            <i class="fas fa-server text-red-600"></i>
                        </div>
                        <div>
                            <h1 class="font-bold text-base text-white">PT MSK</h1>
                            <p class="text-xs text-red-100 hidden md:block">Sistem Monitoring Ruang Server MSK</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - User Menu -->
                <div class="flex items-center space-x-3">
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2 border border-white/20 hover:bg-white/20 transition-all">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md">
                                <i class="fas fa-user text-red-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-white hidden md:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-white text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl overflow-hidden z-50 border-2 border-red-100">
                            <div class="p-4 honda-gradient border-b border-red-700">
                                <p class="text-xs text-red-100 uppercase tracking-wide font-medium mb-1">Account</p>
                                <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-red-50">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="fas fa-user-cog mr-3 text-red-600"></i>
                                    <span class="font-medium">Edit Profile</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-white border-r-4 border-red-600 z-40 overflow-y-auto shadow-xl">
        <div class="p-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line text-base w-5 text-red-600"></i>
                <span class="text-sm">Dashboard</span>
            </a>
            
            <!-- Daftar Checklist -->
            <a href="{{ route('checklists.index') }}" 
               class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('checklists.index') ? 'active' : '' }}">
                <i class="fas fa-list text-base w-5 text-red-600"></i>
                <span class="text-sm">Daftar Checklist</span>
            </a>
            
            <!-- Report Checklist -->
            <a href="{{ route('checklists.report') }}" 
               class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('checklists.report') ? 'active' : '' }}">
                <i class="fas fa-file-alt text-base w-5 text-red-600"></i>
                <span class="text-sm">Report Checklist</span>
            </a>
            
            <!-- Buat Checklist -->
            @if(in_array(auth()->user()->role, ['super_admin', 'admin', 'inspector']))
            <a href="{{ route('checklists.create') }}" 
               class="sidebar-link flex md:hidden items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('checklists.create') ? 'active' : '' }}">
                <i class="fas fa-plus text-base w-5 text-red-600"></i>
                <span class="text-sm">Buat Checklist</span>
            </a>
            @endif
            
            <!-- Management Section -->
            @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
            <div class="pt-4 pb-2">
                <div class="px-4 py-2 honda-accent rounded-lg">
                    <p class="text-xs font-semibold text-white uppercase tracking-wider">Management</p>
                </div>
            </div>
            
            <!-- Kelola Users/Inspector -->
            <a href="{{ route('inspectors.create') }}" 
               class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('inspectors.create') ? 'active' : '' }}">
                <i class="fas fa-users-cog text-base w-5 text-red-600"></i>
                <span class="text-sm">Kelola Users</span>
            </a>
            @endif
            
            <!-- Super Admin Only Menu -->
            @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('settings') }}" 
               class="sidebar-link flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-700 font-medium {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-cog text-base w-5 text-red-600"></i>
                <span class="text-sm">Settings</span>
            </a>
            @endif
            
            <!-- User Info & Role Badge -->
            <div class="pt-4">
                <div class="px-4 py-3 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border-2 border-red-200 shadow-sm">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 honda-gradient rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded mt-1
                                @if(auth()->user()->role === 'super_admin') bg-red-600 text-white
                                @elseif(auth()->user()->role === 'admin') bg-red-500 text-white
                                @elseif(auth()->user()->role === 'inspector') bg-red-400 text-white
                                @else bg-gray-600 text-white
                                @endif shadow-sm">
                                {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="px-4 py-3 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border-2 border-red-200 mt-2 shadow-sm">
                <p class="text-xs text-red-800 font-semibold mb-3 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Quick Info
                </p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Total Checklist</span>
                        <span class="font-bold text-red-600 bg-white px-3 py-1 rounded-full border-2 border-red-200 shadow-sm">
                            {{ \App\Models\ServerChecklist::count() }}
                        </span>
                    </div>
                    @if(in_array(auth()->user()->role, ['super_admin', 'admin', 'viewer']))
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Bulan Ini</span>
                        <span class="font-bold text-red-600 bg-white px-3 py-1 rounded-full border-2 border-red-200 shadow-sm">
                            {{ \App\Models\ServerChecklist::whereMonth('inspection_date', date('m'))->count() }}
                        </span>
                    </div>
                    @else
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Checklist Saya</span>
                        <span class="font-bold text-red-600 bg-white px-3 py-1 rounded-full border-2 border-red-200 shadow-sm">
                            {{ \App\Models\ServerChecklist::where('user_id', auth()->id())->count() }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main :class="sidebarOpen ? 'ml-64' : 'ml-0'" 
          class="pt-20 min-h-screen transition-all duration-300">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer :class="sidebarOpen ? 'ml-64' : 'ml-0'" 
            class="honda-gradient border-t-4 border-red-800 transition-all duration-300 shadow-lg">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-server text-white"></i>
                    <span class="text-sm text-white font-medium">
                        Server Room Checklist PT Mitra Sendang Kemakmuran
                    </span>
                </div>
                <p class="text-sm text-red-100">
                    © {{ date('Y') }} All rights reserved
                </p>
            </div>
        </div>
    </footer>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"></div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>