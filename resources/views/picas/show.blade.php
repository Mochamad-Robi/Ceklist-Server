@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header -->
        <div class="mb-8 bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('picas.index') }}" 
                       class="text-red-600 hover:text-red-700 bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-3 border border-red-200 shadow-md hover:shadow-lg transition-all">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Detail PICA</h1>
                            <p class="text-red-600 font-medium">Problem Identification and Corrective Action</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('picas.edit', $pica) }}" 
                       class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 
                              text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl 
                              flex items-center transition-all transform hover:scale-105">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <form action="{{ route('picas.destroy', $pica) }}" method="POST" class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus PICA ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 
                                       text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl 
                                       flex items-center transition-all transform hover:scale-105">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($pica->status == 'Open')
                <span class="inline-flex items-center px-6 py-3 text-lg font-bold rounded-full bg-yellow-100 text-yellow-800 border-2 border-yellow-300 shadow-lg">
                    <i class="fas fa-hourglass-half mr-2 text-xl"></i>
                    Status: OPEN
                </span>
            @else
                <span class="inline-flex items-center px-6 py-3 text-lg font-bold rounded-full bg-green-100 text-green-800 border-2 border-green-300 shadow-lg">
                    <i class="fas fa-check-circle mr-2 text-xl"></i>
                    Status: CLOSED
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-xl font-bold flex items-center">
                            <i class="fas fa-info-circle mr-3"></i>
                            Informasi Dasar
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg border-2 border-red-200">
                                <p class="text-sm text-red-600 font-bold mb-1 flex items-center">
                                    <i class="fas fa-calendar text-red-600 mr-2"></i>
                                    Tanggal
                                </p>
                                <p class="text-lg font-bold text-gray-900">{{ $pica->tanggal->format('d F Y') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg border-2 border-red-200">
                                <p class="text-sm text-red-600 font-bold mb-1 flex items-center">
                                    <i class="fas fa-clock text-red-600 mr-2"></i>
                                    Target Penyelesaian
                                </p>
                                <p class="text-lg font-bold text-gray-900">{{ $pica->waktu_penyelesaian->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Identifikasi Masalah -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-xl font-bold flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Identifikasi Masalah
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Masalah -->
                        <div>
                            <h3 class="text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-bug text-red-600 mr-2"></i>
                                Deskripsi Masalah
                            </h3>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-500 p-4 rounded-lg">
                                <p class="text-gray-900 leading-relaxed font-medium">{{ $pica->masalah }}</p>
                            </div>
                        </div>

                        <!-- Bukti Masalah -->
                        @if($pica->screen)
                            <div>
                                <h3 class="text-sm font-bold text-red-600 mb-2 flex items-center">
                                    <i class="fas fa-camera text-red-600 mr-2"></i>
                                    Bukti Masalah
                                </h3>
                                <div class="bg-gray-100 p-4 rounded-lg border-2 border-red-200">
                                    <img src="{{ Storage::url($pica->screen) }}" 
                                         alt="Bukti Masalah" 
                                         class="w-full h-auto rounded-lg shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                         onclick="openImageModal('{{ Storage::url($pica->screen) }}')">
                                </div>
                            </div>
                        @endif

                        <!-- Akar Penyebab -->
                        <div>
                            <h3 class="text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-search text-red-600 mr-2"></i>
                                Akar Penyebab (Root Cause)
                            </h3>
                            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-l-4 border-orange-500 p-4 rounded-lg">
                                <p class="text-gray-900 leading-relaxed font-medium">{{ $pica->akar_penyebab }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tindakan Korektif -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-green-100">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h2 class="text-white text-xl font-bold flex items-center">
                            <i class="fas fa-tools mr-3"></i>
                            Tindakan Korektif
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Tindakan Perbaikan -->
                        <div>
                            <h3 class="text-sm font-bold text-green-600 mb-2 flex items-center">
                                <i class="fas fa-wrench text-green-600 mr-2"></i>
                                Tindakan Perbaikan
                            </h3>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 border-l-4 border-green-500 p-4 rounded-lg">
                                <p class="text-gray-900 leading-relaxed font-medium">{{ $pica->tindakan_perbaikan }}</p>
                            </div>
                        </div>

                        <!-- Bukti Perbaikan -->
                        @if($pica->screen_2)
                            <div>
                                <h3 class="text-sm font-bold text-green-600 mb-2 flex items-center">
                                    <i class="fas fa-camera text-green-600 mr-2"></i>
                                    Bukti Perbaikan
                                </h3>
                                <div class="bg-gray-100 p-4 rounded-lg border-2 border-green-200">
                                    <img src="{{ Storage::url($pica->screen_2) }}" 
                                         alt="Bukti Perbaikan" 
                                         class="w-full h-auto rounded-lg shadow-lg cursor-pointer hover:scale-105 transition-transform"
                                         onclick="openImageModal('{{ Storage::url($pica->screen_2) }}')">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pencegahan -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-xl font-bold flex items-center">
                            <i class="fas fa-shield-alt mr-3"></i>
                            Tindakan Pencegahan
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-500 p-4 rounded-lg">
                            <p class="text-gray-900 leading-relaxed font-medium">{{ $pica->pencegahan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- PIC Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-lg font-bold flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Person In Charge
                        </h2>
                    </div>
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-red-500 to-red-600 rounded-full mb-4 shadow-lg border-2 border-red-700">
                            <span class="text-white text-3xl font-bold">{{ strtoupper(substr($pica->pic, 0, 1)) }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $pica->pic }}</h3>
                        <p class="text-sm text-red-600 mt-1 font-bold">Penanggung Jawab</p>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-lg font-bold flex items-center">
                            <i class="fas fa-history mr-2"></i>
                            Timeline
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full flex items-center justify-center mr-3 border-2 border-blue-200">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Dibuat</p>
                                <p class="text-xs text-gray-600 font-medium">{{ $pica->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-full flex items-center justify-center mr-3 border-2 border-yellow-200">
                                <i class="fas fa-edit text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Terakhir Diupdate</p>
                                <p class="text-xs text-gray-600 font-medium">{{ $pica->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center mr-3 border-2 border-red-200">
                                <i class="fas fa-flag-checkered text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Target Selesai</p>
                                <p class="text-xs text-gray-600 font-medium">{{ $pica->waktu_penyelesaian->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-white text-lg font-bold flex items-center">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('picas.edit', $pica) }}" 
                           class="block w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 py-3 rounded-lg font-bold text-center transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-edit mr-2"></i>
                            Edit PICA
                        </a>
                        <button onclick="window.print()" 
                                class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-3 rounded-lg font-bold text-center transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Print
                        </button>
                        <a href="{{ route('picas.index') }}" 
                           class="block w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-4 py-3 rounded-lg font-bold text-center transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-5xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-3xl font-bold">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-screen rounded-lg shadow-2xl border-4 border-white">
    </div>
</div>

<script>
function openImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when pressing ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endsection