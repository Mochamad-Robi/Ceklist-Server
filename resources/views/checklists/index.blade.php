@extends('checklists.layout')

@section('title', 'Daftar Checklist')

@push('styles')
<style>
    tbody tr {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    tbody tr:hover {
        background: linear-gradient(to right, rgba(220, 38, 38, 0.05), transparent);
        border-left: 3px solid #dc2626;
    }
    
    .btn-action {
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .filter-card {
        border: 2px solid #fee2e2;
    }
    
    .table-card {
        border: 2px solid #fee2e2;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header + Button -->
    <div class="flex justify-between items-center w-full bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-list text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Checklist</h1>
                <p class="text-sm text-red-600 font-medium flex items-center">
                    <i class="fas fa-server mr-2"></i>
                    Kelola semua inspeksi ruang server
                </p>
            </div>
        </div>

        <div class="flex gap-2 items-center">
            <a href="{{ route('checklists.create') }}" 
               class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 rounded-lg text-sm font-bold 
                      flex items-center transition-all shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                <span>Buat Baru</span>
            </a>
            
            <a href="{{ route('picas.index') }}" 
               class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 rounded-lg text-sm font-bold 
                      flex items-center transition-all shadow-md hover:shadow-lg">
                <i class="fas fa-eye mr-2"></i>
                <span>Lihat PICA</span>
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg filter-card p-6">
        <div class="flex items-center mb-4">
            <div class="p-2 bg-gradient-to-br from-red-50 to-red-100 rounded-lg mr-3 border border-red-200">
                <i class="fas fa-filter text-red-600"></i>
            </div>
            <h3 class="font-bold text-gray-900">Filter & Pencarian</h3>
        </div>
        
        <form method="GET" action="{{ route('checklists.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Status
                </label>
                <select name="status" class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Inspector
                </label>
                <input type="text" name="inspector" value="{{ request('inspector') }}" placeholder="Nama inspector" 
                       class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Dari Tanggal
                </label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Sampai Tanggal
                </label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-sm">
            </div>
            
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-5 py-2 rounded-lg font-bold transition-all text-sm shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('checklists.index') }}" class="bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 px-5 py-2 rounded-lg font-bold transition-all text-sm border-2 border-gray-300">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg table-card overflow-hidden">
        @if($checklists->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-red-100">
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
                            Hasil
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-red-50">
                    @foreach($checklists as $checklist)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-red-50 to-red-100 p-2 rounded-lg mr-3 border border-red-200">
                                    <i class="fas fa-calendar-day text-red-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $checklist->inspection_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-red-600 font-medium">
                                        {{ $checklist->inspection_date->format('l') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-9 h-9 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white font-bold text-sm">
                                        {{ substr($checklist->inspector_name, 0, 2) }}
                                    </span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $checklist->inspector_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($checklist->status == 'completed')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 inline-flex items-center border-2 border-green-200">
                                    <i class="fas fa-check-circle mr-1.5"></i> Selesai
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 inline-flex items-center border-2 border-yellow-200">
                                    <i class="fas fa-clock mr-1.5"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-32 bg-red-100 rounded-full h-2.5 mr-2 overflow-hidden border border-red-200">
                                    <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $checklist->completion_percentage }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $checklist->completion_percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <span class="bg-green-50 px-2 py-1 rounded-lg border-2 border-green-200 text-green-700 font-bold inline-flex items-center text-xs" title="OK">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $checklist->ok_items }}
                                </span>
                                <span class="bg-red-50 px-2 py-1 rounded-lg border-2 border-red-200 text-red-700 font-bold inline-flex items-center text-xs" title="Tidak OK">
                                    <i class="fas fa-times-circle mr-1"></i> {{ $checklist->not_ok_items }}
                                </span>
                                <span class="bg-yellow-50 px-2 py-1 rounded-lg border-2 border-yellow-200 text-yellow-700 font-bold inline-flex items-center text-xs" title="Perhatian">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $checklist->attention_items }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-1.5">
                                <a href="{{ route('checklists.show', $checklist->id) }}" class="btn-action p-2 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 rounded-lg border border-blue-200 shadow-sm" title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('checklists.edit', $checklist->id) }}" class="btn-action p-2 bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-600 hover:from-yellow-100 hover:to-yellow-200 rounded-lg border border-yellow-200 shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="{{ route('checklists.export-csv', $checklist->id) }}" class="btn-action p-2 bg-gradient-to-br from-green-50 to-green-100 text-green-600 hover:from-green-100 hover:to-green-200 rounded-lg border border-green-200 shadow-sm" title="Export CSV">
                                    <i class="fas fa-download text-sm"></i>
                                </a>
                                <button onclick="deleteChecklist({{ $checklist->id }})" class="btn-action p-2 bg-gradient-to-br from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 rounded-lg border border-red-200 shadow-sm" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-t-2 border-red-200">
            {{ $checklists->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <div class="inline-block p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-full mb-4 border-2 border-red-200">
                <i class="fas fa-inbox text-red-400 text-5xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Data</h3>
            <p class="text-red-600 text-sm mb-6 font-medium">Belum ada checklist yang tersedia</p>
            <a href="{{ route('checklists.create') }}" class="inline-flex items-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-5 py-2.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Buat Checklist Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function deleteChecklist(id) {
    if (confirm('Yakin ingin menghapus checklist ini?')) {
        fetch(`/checklists/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus checklist');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
            console.error(error);
        });
    }
}
</script>
@endpush
@endsection