@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Daftar PICA
                        </h1>
                        <p class="text-red-600 font-medium">Problem Identification and Corrective Action</p>
                    </div>
                </div>
                <a href="{{ route('picas.create') }}" 
                   class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 
                          text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl 
                          flex items-center justify-center transition-all transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2 text-lg"></i>
                    <span>Tambah PICA Baru</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Total PICA -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-red-600 font-bold uppercase tracking-wider">Total PICA</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $picas->total() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-full p-4 border-2 border-red-200">
                        <i class="fas fa-clipboard-list text-2xl text-red-600"></i>
                    </div>
                </div>
            </div>

            <!-- Open PICA -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-yellow-600 font-bold uppercase tracking-wider">Status Open</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $picas->where('status', 'Open')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-full p-4 border-2 border-yellow-200">
                        <i class="fas fa-hourglass-half text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Closed PICA -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600 font-bold uppercase tracking-wider">Status Close</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $picas->where('status', 'Close')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-full p-4 border-2 border-green-200">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-red-600 font-bold uppercase tracking-wider">Completion Rate</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            {{ $picas->total() > 0 ? round(($picas->where('status', 'Close')->count() / $picas->total()) * 100) : 0 }}%
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-full p-4 border-2 border-red-200">
                        <i class="fas fa-chart-pie text-2xl text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-lg flex items-center animate-fade-in">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Cari masalah, PIC, atau deskripsi..." 
                               class="w-full pl-12 pr-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <i class="fas fa-search absolute left-4 top-4 text-red-400"></i>
                    </div>
                </div>
                <select class="px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-medium">
                    <option value="">Semua Status</option>
                    <option value="Open">Open</option>
                    <option value="Close">Close</option>
                </select>
                <button class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-lg font-bold flex items-center justify-center shadow-md hover:shadow-lg transition-all">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden border-2 border-red-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y-2 divide-red-100">
                    <thead class="bg-gradient-to-r from-red-600 to-red-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Masalah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Akar Penyebab</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tindakan Perbaikan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Target Selesai</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">PIC</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-50">
                        @forelse($picas as $index => $pica)
                            <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-transparent transition-all border-l-3 hover:border-l-red-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $picas->firstItem() + $index }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-br from-red-50 to-red-100 p-2 rounded-lg mr-2 border border-red-200">
                                            <i class="fas fa-calendar text-red-600"></i>
                                        </div>
                                        <span class="text-sm text-gray-900 font-medium">{{ $pica->tanggal->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        <p class="font-bold">{{ Str::limit($pica->masalah, 60) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs font-medium">
                                        {{ Str::limit($pica->akar_penyebab, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs font-medium">
                                        {{ Str::limit($pica->tindakan_perbaikan, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-br from-red-50 to-red-100 p-2 rounded-lg mr-2 border border-red-200">
                                            <i class="fas fa-flag text-red-600"></i>
                                        </div>
                                        <span class="text-sm text-gray-900 font-medium">{{ $pica->waktu_penyelesaian->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-md border border-red-700">
                                            <span class="text-white text-sm font-bold">{{ strtoupper(substr($pica->pic, 0, 1)) }}</span>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-900 font-bold">{{ $pica->pic }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pica->status == 'Open')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700 border-2 border-yellow-300">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Open
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 border-2 border-green-300">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Close
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('picas.show', $pica) }}" 
                                           class="p-2 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 rounded-lg border border-blue-200 transition-all shadow-sm hover:shadow-md"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('picas.edit', $pica) }}" 
                                           class="p-2 bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-600 hover:from-yellow-100 hover:to-yellow-200 rounded-lg border border-yellow-200 transition-all shadow-sm hover:shadow-md"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('picas.destroy', $pica) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus PICA ini?\n\nMasalah: {{ Str::limit($pica->masalah, 50) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-gradient-to-br from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 rounded-lg border border-red-200 transition-all shadow-sm hover:shadow-md"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-full p-8 mb-4 border-2 border-red-200">
                                            <i class="fas fa-inbox text-6xl text-red-400"></i>
                                        </div>
                                        <p class="text-xl font-bold text-gray-900 mb-2">Belum ada data PICA</p>
                                        <p class="text-sm text-red-600 mb-6 font-medium">Mulai tambahkan PICA pertama Anda</p>
                                        <a href="{{ route('picas.create') }}" 
                                           class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 
                                                  text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl 
                                                  flex items-center transition-all transform hover:scale-105">
                                            <i class="fas fa-plus-circle mr-2"></i>
                                            Tambah PICA Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $picas->links() }}
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection