@extends('layouts.app')

@section('title', 'Report & Analytics')

@section('content')
<div class="space-y-8">
    <!-- Header with Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-red-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Report & Analytics</h1>
                        <p class="text-sm text-red-600 font-medium">Comprehensive server room monitoring insights</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all flex items-center space-x-2 text-sm font-bold shadow-md hover:shadow-lg">
                    <i class="fas fa-print"></i>
                    <span>Print</span>
                </button>
                <button onclick="exportToExcel()" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition-all flex items-center space-x-2 text-sm font-bold shadow-md hover:shadow-lg">
                    <i class="fas fa-file-excel"></i>
                    <span>Excel</span>
                </button>
                <button onclick="exportToPDF()" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all flex items-center space-x-2 text-sm font-bold shadow-md hover:shadow-lg">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-red-100 border-b-2 border-red-200 px-6 py-4">
            <h2 class="text-base font-bold text-gray-900 flex items-center">
                <i class="fas fa-sliders-h mr-2 text-red-600"></i>
                Filters
            </h2>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('checklists.report') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-bold text-red-600 mb-2">
                        Start Date
                    </label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full px-3 py-2 border-2 border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-red-600 mb-2">
                        End Date
                    </label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full px-3 py-2 border-2 border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-bold text-red-600 mb-2">
                        Status
                    </label>
                    <select name="status" class="w-full px-3 py-2 border-2 border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm font-medium">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all font-bold text-sm shadow-md hover:shadow-lg">
                        Apply
                    </button>
                    <a href="{{ route('checklists.report') }}" class="px-3 py-2 bg-gradient-to-br from-red-50 to-red-100 text-red-600 rounded-lg hover:from-red-100 hover:to-red-200 transition-all border border-red-200">
                        <i class="fas fa-redo text-sm"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Checklists -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-red-100 hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 rounded-lg flex items-center justify-center border-2 border-red-200">
                    <i class="fas fa-clipboard-list text-red-600 text-xl"></i>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200">TOTAL</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $checklists->total() }}</h3>
            <p class="text-sm text-red-600 font-medium">Total Checklists</p>
            <div class="mt-3 flex items-center text-xs">
                <i class="fas fa-arrow-up text-green-600 mr-1"></i>
                <span class="text-green-600 font-bold">+12.5%</span>
                <span class="text-gray-500 ml-1 font-medium">vs last period</span>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-green-100 hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-lg flex items-center justify-center border-2 border-green-200">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-200">SUCCESS</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $completedCount }}</h3>
            <p class="text-sm text-green-600 font-medium">Completed</p>
            <div class="mt-3 w-full bg-red-100 rounded-full h-2 border border-red-200">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $checklists->total() > 0 ? ($completedCount / $checklists->total() * 100) : 0 }}%"></div>
            </div>
        </div>

        <!-- Draft -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-yellow-100 hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg flex items-center justify-center border-2 border-yellow-200">
                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                </div>
                <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded border border-yellow-200">PENDING</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $draftCount }}</h3>
            <p class="text-sm text-yellow-600 font-medium">Draft</p>
            <div class="mt-3 w-full bg-red-100 rounded-full h-2 border border-red-200">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $checklists->total() > 0 ? ($draftCount / $checklists->total() * 100) : 0 }}%"></div>
            </div>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-red-100 hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 rounded-lg flex items-center justify-center border-2 border-red-200">
                    <i class="fas fa-calendar-alt text-red-600 text-xl"></i>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200">MONTH</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $thisMonthCount }}</h3>
            <p class="text-sm text-red-600 font-medium">Current Month</p>
            <div class="mt-3 flex items-center text-xs">
                <i class="fas fa-calendar-week text-red-600 mr-1"></i>
                <span class="text-red-600 font-bold">{{ date('F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Data Insights -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-b-2 border-red-200 px-6 py-4">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <i class="fas fa-clock mr-2 text-red-600"></i>
                    Activity Summary
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:from-red-100 hover:to-red-200 transition-all border border-red-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-calendar-day text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Today</span>
                    </div>
                    <span class="text-2xl font-bold text-red-600">{{ $todayCount ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:from-red-100 hover:to-red-200 transition-all border border-red-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-calendar-week text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-gray-900">This Week</span>
                    </div>
                    <span class="text-2xl font-bold text-red-600">{{ $weekCount ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:from-red-100 hover:to-red-200 transition-all border border-red-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-gray-900">This Month</span>
                    </div>
                    <span class="text-2xl font-bold text-red-600">{{ $thisMonthCount }}</span>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-b-2 border-red-200 px-6 py-4">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-red-600"></i>
                    Completion Rate
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="text-center">
                    <p class="text-5xl font-bold text-red-600 mb-1">
                        {{ $checklists->total() > 0 ? number_format(($completedCount / ($completedCount + $draftCount)) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-sm text-gray-600 font-medium">Overall Completion Rate</p>
                </div>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-1.5">
                            <span class="text-gray-700">Completed</span>
                            <span class="text-green-600">{{ $completedCount }}</span>
                        </div>
                        <div class="w-full bg-red-100 rounded-full h-2.5 border border-red-200">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2.5 rounded-full transition-all duration-500 shadow-sm" style="width: {{ ($completedCount + $draftCount) > 0 ? ($completedCount / ($completedCount + $draftCount) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-1.5">
                            <span class="text-gray-700">Draft</span>
                            <span class="text-yellow-600">{{ $draftCount }}</span>
                        </div>
                        <div class="w-full bg-red-100 rounded-full h-2.5 border border-red-200">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2.5 rounded-full transition-all duration-500 shadow-sm" style="width: {{ ($completedCount + $draftCount) > 0 ? ($draftCount / ($completedCount + $draftCount) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-red-100 border-b-2 border-red-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-900 flex items-center">
                    <i class="fas fa-history mr-2 text-red-600"></i>
                    Recent Activities
                </h2>
                <span class="text-sm text-red-600 font-bold">
                    Last {{ $checklists->count() }} records
                </span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-red-600 to-red-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Inspector</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-50">
                    @forelse($checklists as $index => $checklist)
                    <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-transparent transition-all border-l-3 hover:border-l-red-600">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900">{{ $checklists->firstItem() + $index }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($checklist->inspection_date)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-md">
                                    <span class="text-white text-xs font-bold">{{ substr($checklist->inspector_name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm text-gray-900 font-bold">{{ $checklist->inspector_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($checklist->status == 'completed')
                                <span class="px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full border-2 border-green-200">
                                    Completed
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full border-2 border-yellow-200">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('checklists.show', $checklist->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-bold rounded-lg transition-all shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-1.5"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center border-2 border-red-200">
                                    <i class="fas fa-inbox text-red-400 text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-900">No Data Found</p>
                                    <p class="text-sm text-red-600 mt-1 font-medium">Try adjusting your filters or create a new checklist</p>
                                </div>
                                <a href="{{ route('checklists.create') }}" class="mt-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all text-sm font-bold shadow-md hover:shadow-lg">
                                    <i class="fas fa-plus mr-2"></i>Create Checklist
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($checklists->hasPages())
        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-red-100 border-t-2 border-red-200">
            {{ $checklists->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function exportToExcel() {
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'excel');
    window.location.href = '{{ route("checklists.report") }}?' + params.toString();
}

function exportToPDF() {
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'pdf');
    window.location.href = '{{ route("checklists.report") }}?' + params.toString();
}
</script>
@endpush

@push('styles')
<style>
@media print {
    nav, aside, footer, .no-print, button {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    main {
        margin: 0 !important;
        padding: 20px !important;
    }
}
</style>
@endpush
@endsection