@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">System Settings</h1>
                    <p class="text-gray-600">Kelola dan monitor sistem checklist Anda</p>
                </div>
                <div class="flex items-center space-x-2 px-4 py-2 bg-white rounded-lg border border-gray-200">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-700">System Active</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-gray-700 text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\User::count() }}</h3>
                <p class="text-sm text-gray-600">Total Users</p>
            </div>

            <!-- Total Checklists -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-gray-700 text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Total</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\ServerChecklist::count() }}</h3>
                <p class="text-sm text-gray-600">Checklists</p>
            </div>

            <!-- This Month -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-gray-700 text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Monthly</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\ServerChecklist::whereMonth('created_at', date('m'))->count() }}</h3>
                <p class="text-sm text-gray-600">This Month</p>
            </div>

            <!-- Storage -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-database text-gray-700 text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Storage</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">2.5</h3>
                <p class="text-sm text-gray-600">MB Used</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- User Role Distribution -->
            <div class="lg:col-span-2 bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">User Distribution</h3>
                        <p class="text-sm text-gray-600">Breakdown by role</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-friends text-gray-700"></i>
                    </div>
                </div>

                <div class="space-y-5">
                    @php
                        $totalUsers = \App\Models\User::count();
                        $superAdmins = \App\Models\User::where('role', 'super_admin')->count();
                        $admins = \App\Models\User::where('role', 'admin')->count();
                        $inspectors = \App\Models\User::where('role', 'inspector')->count();
                        $viewers = \App\Models\User::where('role', 'viewer')->count();
                    @endphp

                    <!-- Super Admin -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-crown text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Super Admin</p>
                                    <p class="text-xs text-gray-500">Full system access</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">{{ $superAdmins }}</p>
                                <p class="text-xs text-gray-500">{{ $totalUsers > 0 ? round(($superAdmins/$totalUsers)*100) : 0 }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gray-900 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalUsers > 0 ? ($superAdmins/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Admin -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-shield text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Admin</p>
                                    <p class="text-xs text-gray-500">Management access</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">{{ $admins }}</p>
                                <p class="text-xs text-gray-500">{{ $totalUsers > 0 ? round(($admins/$totalUsers)*100) : 0 }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gray-700 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalUsers > 0 ? ($admins/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Inspector -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Inspector</p>
                                    <p class="text-xs text-gray-500">Create & view checklists</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">{{ $inspectors }}</p>
                                <p class="text-xs text-gray-500">{{ $totalUsers > 0 ? round(($inspectors/$totalUsers)*100) : 0 }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gray-600 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalUsers > 0 ? ($inspectors/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Viewer -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-400 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-eye text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Viewer</p>
                                    <p class="text-xs text-gray-500">Read-only access</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">{{ $viewers }}</p>
                                <p class="text-xs text-gray-500">{{ $totalUsers > 0 ? round(($viewers/$totalUsers)*100) : 0 }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gray-400 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalUsers > 0 ? ($viewers/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">System Info</h3>
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-server text-gray-700"></i>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-code-branch text-gray-600"></i>
                            <span class="text-sm text-gray-700 font-medium">Version</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">v1.0.0</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-calendar text-gray-600"></i>
                            <span class="text-sm text-gray-700 font-medium">Last Backup</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ now()->format('d M') }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-gray-600"></i>
                            <span class="text-sm text-gray-700 font-medium">Uptime</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">99.9%</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-database text-gray-600"></i>
                            <span class="text-sm text-gray-700 font-medium">DB Size</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">2.5 MB</span>
                    </div>
                </div>

                <button class="w-full mt-6 bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                    <i class="fas fa-download mr-2"></i>Download Report
                </button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Maintenance -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-sync-alt text-gray-700"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Clear Cache</h4>
                        <p class="text-xs text-gray-500">Refresh system cache</p>
                    </div>
                </div>
                <button class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                    Execute
                </button>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-broom text-gray-700"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Clear Logs</h4>
                        <p class="text-xs text-gray-500">Remove old log files</p>
                    </div>
                </div>
                <button class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                    Execute
                </button>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-wrench text-gray-700"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Optimize DB</h4>
                        <p class="text-xs text-gray-500">Optimize database</p>
                    </div>
                </div>
                <button class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                    Execute
                </button>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-lg p-6 border-2 border-red-200">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-red-600">Danger Zone</h3>
                    <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="bg-white border-2 border-red-200 text-red-600 py-3 rounded-lg font-semibold hover:bg-red-50 transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>Reset Data
                </button>
                
                <button class="bg-white border-2 border-orange-200 text-orange-600 py-3 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                    <i class="fas fa-user-slash mr-2"></i>Delete Users
                </button>
                
                <button class="bg-white border-2 border-yellow-200 text-yellow-600 py-3 rounded-lg font-semibold hover:bg-yellow-50 transition-colors">
                    <i class="fas fa-archive mr-2"></i>Archive Old
                </button>
            </div>
        </div>
    </div>
</div>
@endsection