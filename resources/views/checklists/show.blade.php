@extends('checklists.layout')

@section('title', 'Detail Checklist')

@section('content')
<div class="space-y-6">
    <!-- Header with Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('checklists.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-sm font-medium text-gray-900">Detail Checklist</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-clipboard-check mr-2 text-gray-700"></i>
                    Detail Checklist
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $checklist->inspection_date->format('d F Y') }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('checklists.edit', $checklist->id) }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-edit mr-2"></i> 
                    <span>Edit</span>
                </a>
                <a href="{{ route('checklists.export-csv', $checklist->id) }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-download mr-2"></i> 
                    <span>Export</span>
                </a>
                <button onclick="window.print()" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-print mr-2"></i> 
                    <span>Print</span>
                </button>
                <a href="{{ route('checklists.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    @if($checklist->status == 'completed')
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-900 font-medium">Checklist Telah Selesai</p>
                <p class="text-sm text-green-800 mt-1">Inspeksi telah diselesaikan pada {{ $checklist->updated_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-900 font-medium">Checklist Masih Draft</p>
                <p class="text-sm text-yellow-800 mt-1">Checklist ini belum diselesaikan. Klik tombol Edit untuk melanjutkan.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Info Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="bg-gray-100 rounded-lg p-2 mr-3">
                <i class="fas fa-info-circle text-gray-700"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Informasi Inspeksi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-user mr-2 text-gray-500"></i>
                    Inspector
                </label>
                <p class="text-base font-semibold text-gray-900 mt-2">{{ $checklist->inspector_name }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-flag mr-2 text-gray-500"></i>
                    Status
                </label>
                <div class="mt-2">
                    @if($checklist->status == 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i> Draft
                        </span>
                    @endif
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <label class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-calendar-plus mr-2 text-gray-500"></i>
                    Dibuat
                </label>
                <p class="text-base font-semibold text-gray-900 mt-2">{{ $checklist->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="bg-gray-900 rounded-lg p-2 mr-3">
                <i class="fas fa-chart-pie text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Statistik</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center border border-gray-200">
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-600">Total Item</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center border border-gray-200">
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['checked'] }}</div>
                <div class="text-sm text-gray-600">Diperiksa</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center border border-gray-200">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['ok'] }}</div>
                <div class="text-sm text-gray-600">OK</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center border border-gray-200">
                <div class="text-3xl font-bold text-red-600 mb-2">{{ $stats['not_ok'] }}</div>
                <div class="text-sm text-gray-600">Tidak OK</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center border border-gray-200">
                <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $stats['attention'] }}</div>
                <div class="text-sm text-gray-600">Perhatian</div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="bg-gray-100 rounded-lg p-2 mr-3">
                <i class="fas fa-chart-line text-gray-700"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Progress Pemeriksaan</h3>
        </div>
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Tingkat Penyelesaian</span>
            <span class="text-xl font-bold text-gray-900">{{ $stats['completion_percentage'] }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
            <div class="bg-gray-900 h-4 rounded-full transition-all duration-500 flex items-center justify-end pr-2" style="width: {{ $stats['completion_percentage'] }}%">
                @if($stats['completion_percentage'] > 10)
                <span class="text-xs font-medium text-white">{{ $stats['completion_percentage'] }}%</span>
                @endif
            </div>
        </div>
        @if($stats['completion_percentage'] == 100)
        <div class="mt-3 text-center">
            <span class="inline-flex items-center text-sm font-medium text-green-600">
                <i class="fas fa-trophy mr-1"></i>
                Semua item telah diperiksa!
            </span>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    @if($stats['not_ok'] > 0 || $stats['attention'] > 0)
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-900">Memerlukan Tindak Lanjut</h3>
                <div class="mt-2 text-sm text-red-800">
                    <p>Terdapat 
                        @if($stats['not_ok'] > 0)
                            <strong>{{ $stats['not_ok'] }}</strong> item tidak OK
                        @endif
                        @if($stats['not_ok'] > 0 && $stats['attention'] > 0)
                            dan
                        @endif
                        @if($stats['attention'] > 0)
                            <strong>{{ $stats['attention'] }}</strong> item yang perlu perhatian
                        @endif
                        dalam inspeksi ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Checklist Items -->
    <div class="space-y-4">
        @foreach($checklist->checklist_data as $categoryIndex => $category)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-white flex items-center">
                    <i class="fas fa-folder-open mr-2"></i>
                    {{ $category['category'] }}
                </h3>
                <div class="flex items-center gap-4">
                    @php
                        $categoryTotal = count($category['items']);
                        $categoryChecked = collect($category['items'])->filter(fn($i) => !empty($i['status']))->count();
                    @endphp
                    <span class="bg-white bg-opacity-20 text-white text-sm font-medium px-2.5 py-1 rounded-full">
                        {{ $categoryChecked }} / {{ $categoryTotal }} items
                    </span>
                    <div class="w-20 bg-white bg-opacity-20 rounded-full h-1.5">
                        <div class="bg-white h-1.5 rounded-full transition-all" style="width: {{ $categoryTotal > 0 ? ($categoryChecked/$categoryTotal*100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($category['items'] as $itemIndex => $item)
                    <div class="flex items-start gap-4 p-4 border-l-4 rounded-r-lg transition-colors
                        @if($item['status'] == 'ok') border-green-500 bg-green-50
                        @elseif($item['status'] == 'not-ok') border-red-500 bg-red-50
                        @elseif($item['status'] == 'attention') border-yellow-500 bg-yellow-50
                        @else border-gray-300 bg-gray-50
                        @endif">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center border-2
                                @if($item['status'] == 'ok') border-green-500
                                @elseif($item['status'] == 'not-ok') border-red-500
                                @elseif($item['status'] == 'attention') border-yellow-500
                                @else border-gray-300
                                @endif">
                                <span class="text-sm font-semibold
                                    @if($item['status'] == 'ok') text-green-600
                                    @elseif($item['status'] == 'not-ok') text-red-600
                                    @elseif($item['status'] == 'attention') text-yellow-600
                                    @else text-gray-600
                                    @endif">
                                    {{ $itemIndex + 1 }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $item['item'] }}</p>
                            @if(!empty($item['note']))
                            <div class="mt-2 bg-white rounded-lg p-3 border border-gray-200">
                                <p class="text-sm text-gray-700 italic flex items-start">
                                    <i class="fas fa-comment-dots mr-2 text-gray-400 mt-0.5"></i>
                                    <span>{{ $item['note'] }}</span>
                                </p>
                            </div>
                            @endif
                        </div>
                        <div class="flex-shrink-0">
                            @if($item['status'] == 'ok')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-600 text-white">
                                    <i class="fas fa-check-circle mr-1.5"></i> OK
                                </span>
                            @elseif($item['status'] == 'not-ok')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-600 text-white">
                                    <i class="fas fa-times-circle mr-1.5"></i> Tidak OK
                                </span>
                            @elseif($item['status'] == 'attention')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-600 text-white">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i> Perhatian
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-300 text-gray-700">
                                    <i class="fas fa-minus-circle mr-1.5"></i> Belum
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Notes Section -->
    @if($checklist->notes)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="bg-gray-100 rounded-lg p-2 mr-3">
                <i class="fas fa-sticky-note text-gray-700"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Catatan Tambahan</h3>
        </div>
        <div class="bg-gray-50 border-l-4 border-gray-300 p-4 rounded-r-lg">
            <p class="text-gray-900 leading-relaxed whitespace-pre-line">{{ $checklist->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Action Summary Footer -->
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 print:hidden">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <p class="text-sm text-gray-600">
                    Checklist ID: <strong class="text-gray-900">#{{ $checklist->id }}</strong>
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    Terakhir diupdate: <strong class="text-gray-900">{{ $checklist->updated_at->format('d F Y, H:i') }} WIB</strong>
                </p>
            </div>
            <div class="flex gap-2">
                @if($checklist->status != 'completed')
                <a href="{{ route('checklists.edit', $checklist->id) }}" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Lanjutkan Edit
                </a>
                @endif
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center text-sm font-medium">
                    <i class="fas fa-arrow-up mr-2"></i>
                    Ke Atas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Print Styles -->
<style>
    @media print {
        .print\:hidden {
            display: none !important;
        }
        
        body {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }
    
    html {
        scroll-behavior: smooth;
    }
</style>

@endsection