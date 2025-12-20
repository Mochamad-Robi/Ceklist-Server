@extends('checklists.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #dc2626, #b91c1c);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.15);
    }
    
    .chart-container {
        transition: all 0.3s ease;
        border: 2px solid #fee2e2;
    }
    
    .chart-container:hover {
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.12);
        border-color: #fca5a5;
    }
    
    .table-row {
        transition: all 0.2s ease;
    }
    
    .table-row:hover {
        background: linear-gradient(to right, rgba(220, 38, 38, 0.03), transparent);
        border-left: 3px solid #dc2626;
    }
    
    .honda-gradient-bg {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .honda-icon {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .progress-bar-red {
        background: linear-gradient(90deg, #dc2626, #ef4444);
    }
    
    .stat-icon-glow {
        box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
    }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-red-50 to-transparent rounded-full -mr-32 -mt-32 opacity-50"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 honda-gradient-bg rounded-xl flex items-center justify-center shadow-lg stat-icon-glow">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-red-600 mt-0.5 font-medium">Ringkasan & Analisis Checklist Ruang Server</p>
                    </div>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-red-50 to-red-100 px-4 py-2 rounded-xl border-2 border-red-200">
                <i class="fas fa-clock text-red-600"></i>
                <div class="text-sm">
                    <div class="text-gray-900 font-medium">{{ now()->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Checklist -->
        <div class="stat-card bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">
                        Total Checklist
                    </p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $stats['total'] }}
                    </h3>
                    <p class="text-xs text-gray-500">Semua waktu</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center border-2 border-red-200">
                    <i class="fas fa-clipboard-list text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="stat-card bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">
                        Selesai
                    </p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $stats['completed'] }}
                    </h3>
                    <p class="text-xs text-green-600 font-medium">
                        {{ $stats['completed_percentage'] }}% dari total
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center border-2 border-green-200">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-red-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all shadow-sm" style="width: {{ $stats['completed_percentage'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Draft -->
        <div class="stat-card bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">
                        Draft
                    </p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $stats['draft'] }}
                    </h3>
                    <p class="text-xs text-yellow-600 font-medium">
                        Belum selesai
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl flex items-center justify-center border-2 border-yellow-200">
                    <i class="fas fa-edit text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="stat-card bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">
                        Bulan Ini
                    </p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $stats['this_month'] }}
                    </h3>
                    <p class="text-xs text-gray-500">
                        {{ date('F Y') }}
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center border-2 border-red-200">
                    <i class="fas fa-calendar-alt text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Distribution Chart -->
        <div class="chart-container bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="p-2 honda-gradient-bg rounded-lg mr-3 shadow-md">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Status Distribution</h3>
                        <p class="text-xs text-red-600 mt-0.5 font-medium">Perbandingan status checklist</p>
                    </div>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Monthly Trend Chart -->
        <div class="chart-container bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="p-2 honda-gradient-bg rounded-lg mr-3 shadow-md">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Trend Bulanan</h3>
                        <p class="text-xs text-red-600 mt-0.5 font-medium">6 Bulan Terakhir</p>
                    </div>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Results Overview Chart -->
    <div class="chart-container bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-2 honda-gradient-bg rounded-lg mr-3 shadow-md">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Hasil Pemeriksaan Overview</h3>
                    <p class="text-xs text-red-600 mt-0.5 font-medium">Total hasil dari semua checklist</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="text-center px-4 py-2 bg-green-50 rounded-lg border-2 border-green-200">
                    <div class="text-xl font-bold text-green-600">{{ $results_stats['ok'] }}</div>
                    <div class="text-xs text-green-700 font-medium">OK</div>
                </div>
                <div class="text-center px-4 py-2 bg-red-50 rounded-lg border-2 border-red-200">
                    <div class="text-xl font-bold text-red-600">{{ $results_stats['not_ok'] }}</div>
                    <div class="text-xs text-red-700 font-medium">Not OK</div>
                </div>
                <div class="text-center px-4 py-2 bg-yellow-50 rounded-lg border-2 border-yellow-200">
                    <div class="text-xl font-bold text-yellow-600">{{ $results_stats['attention'] }}</div>
                    <div class="text-xs text-yellow-700 font-medium">Attention</div>
                </div>
            </div>
        </div>
        <div style="height: 260px;">
            <canvas id="resultsChart"></canvas>
        </div>
    </div>

    <!-- Recent Checklists -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="p-2 honda-gradient-bg rounded-lg mr-3 shadow-md">
                    <i class="fas fa-history text-white"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Checklist Terbaru</h3>
                    <p class="text-xs text-red-600 mt-0.5 font-medium">Aktivitas checklist terkini</p>
                </div>
            </div>
            <a href="{{ route('checklists.index') }}" class="flex items-center space-x-2 text-sm honda-gradient-bg hover:shadow-lg text-white px-4 py-2 rounded-lg font-medium transition-all">
                <span>Lihat Semua</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto rounded-xl border-2 border-red-100">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-red-50 to-red-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Inspector
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Progress
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-100 bg-white">
                    @foreach($recent_checklists as $checklist)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-red-50 to-red-100 p-2 rounded-lg mr-3 border border-red-200">
                                    <i class="fas fa-calendar-day text-red-600"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $checklist->inspection_date->format('d/m/Y') }}
                                    </span>
                                    <div class="text-xs text-red-600">
                                        {{ $checklist->inspection_date->format('l') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 honda-gradient-bg rounded-lg flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white font-bold text-sm">
                                        {{ substr($checklist->inspector_name, 0, 2) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $checklist->inspector_name }}</span>
                                    <div class="text-xs text-red-600 font-medium">Inspector</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($checklist->status == 'completed')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border-2 border-green-200">
                                    <i class="fas fa-check-circle mr-1.5"></i> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border-2 border-yellow-200">
                                    <i class="fas fa-clock mr-1.5"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-32 bg-red-100 rounded-full h-2.5 mr-2 border border-red-200">
                                    <div class="progress-bar-red h-2.5 rounded-full transition-all shadow-sm" style="width: {{ $checklist->completion_percentage }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $checklist->completion_percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('checklists.show', $checklist->id) }}" class="inline-flex items-center honda-gradient-bg hover:shadow-lg text-white px-4 py-2 rounded-lg font-medium transition-all">
                                <i class="fas fa-eye mr-2"></i>
                                <span>Detail</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Status Distribution Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Selesai', 'Draft'],
        datasets: [{
            data: [{{ $stats['completed'] }}, {{ $stats['draft'] }}],
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(234, 179, 8, 0.8)'
            ],
            borderColor: [
                'rgba(34, 197, 94, 1)',
                'rgba(234, 179, 8, 1)'
            ],
            borderWidth: 3,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        weight: 'bold'
                    },
                    padding: 15
                }
            }
        }
    }
});

// Monthly Trend Line Chart - Honda Red Theme
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($monthly_trend)) !!},
        datasets: [{
            label: 'Jumlah Checklist',
            data: {!! json_encode(array_values($monthly_trend)) !!},
            borderColor: 'rgba(220, 38, 38, 1)',
            backgroundColor: 'rgba(220, 38, 38, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointRadius: 6,
            pointBackgroundColor: 'rgba(220, 38, 38, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 3,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: {
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(220, 38, 38, 0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(220, 38, 38, 0.05)'
                },
                ticks: {
                    font: {
                        weight: 'bold'
                    }
                }
            }
        }
    }
});

// Results Overview Bar Chart - Honda Theme
const resultsCtx = document.getElementById('resultsChart').getContext('2d');
new Chart(resultsCtx, {
    type: 'bar',
    data: {
        labels: ['OK', 'Tidak OK', 'Perlu Perhatian'],
        datasets: [{
            label: 'Total Item',
            data: [{{ $results_stats['ok'] }}, {{ $results_stats['not_ok'] }}, {{ $results_stats['attention'] }}],
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(220, 38, 38, 0.8)',
                'rgba(234, 179, 8, 0.8)'
            ],
            borderColor: [
                'rgba(34, 197, 94, 1)',
                'rgba(220, 38, 38, 1)',
                'rgba(234, 179, 8, 1)'
            ],
            borderWidth: 3,
            borderRadius: 8,
            hoverBackgroundColor: [
                'rgba(34, 197, 94, 1)',
                'rgba(220, 38, 38, 1)',
                'rgba(234, 179, 8, 1)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(220, 38, 38, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        weight: 'bold'
                    }
                }
            }
        }
    }
});
</script>
@endpush
@endsection