@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Header -->
        <div class="mb-8 bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
            <div class="flex items-center">
                <a href="{{ route('picas.index') }}" 
                   class="text-red-600 hover:text-red-700 mr-4 p-2 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border border-red-200 transition-all hover:shadow-md">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-plus-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Tambah PICA Baru</h1>
                        <p class="text-red-600 font-medium">Problem Identification and Corrective Action</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
            <form action="{{ route('picas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Informasi Dasar -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-info-circle mr-3"></i>
                        Informasi Dasar
                    </h2>
                </div>
                <div class="p-8 border-b-2 border-red-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="group">
                            <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-calendar text-red-600 mr-2"></i>
                                Tanggal <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                                   class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('tanggal') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- PIC -->
                        <div class="group">
                            <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-user text-red-600 mr-2"></i>
                                PIC (Person In Charge) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="pic" value="{{ old('pic') }}" 
                                   placeholder="Masukkan nama PIC"
                                   class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('pic') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('pic')
                                <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Identifikasi Masalah -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Identifikasi Masalah
                    </h2>
                </div>
                <div class="p-8 border-b-2 border-red-100 bg-gradient-to-br from-red-50 to-red-100">
                    <!-- Masalah -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                            <i class="fas fa-bug text-red-600 mr-2"></i>
                            Deskripsi Masalah <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="masalah" rows="4" 
                                  placeholder="Jelaskan masalah yang ditemukan secara detail..."
                                  class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('masalah') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('masalah') }}</textarea>
                        @error('masalah')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Screen 1 -->
                    <div>
                        <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                            <i class="fas fa-camera text-red-600 mr-2"></i>
                            Bukti Masalah (Screenshot/Foto)
                        </label>
                        <div class="border-2 border-dashed border-red-300 bg-white rounded-lg p-6 hover:border-red-500 transition-all hover:shadow-md">
                            <input type="file" name="screen" accept="image/*" id="screen"
                                   class="hidden"
                                   onchange="previewImage(this, 'preview1')">
                            <label for="screen" class="cursor-pointer flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-red-400 mb-2"></i>
                                <span class="text-sm text-gray-700 font-medium">Klik untuk upload gambar</span>
                                <span class="text-xs text-red-500 mt-1 font-medium">PNG, JPG, GIF hingga 2MB</span>
                            </label>
                            <div id="preview1" class="mt-4 hidden">
                                <img src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto border-2 border-red-200">
                            </div>
                        </div>
                        @error('screen')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Akar Penyebab -->
                    <div class="mt-6">
                        <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                            <i class="fas fa-search text-red-600 mr-2"></i>
                            Akar Penyebab (Root Cause) <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="akar_penyebab" rows="4" 
                                  placeholder="Analisis akar penyebab masalah menggunakan metode 5 Why, Fishbone, dll..."
                                  class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('akar_penyebab') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('akar_penyebab') }}</textarea>
                        @error('akar_penyebab')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Tindakan Korektif -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-tools mr-3"></i>
                        Tindakan Korektif
                    </h2>
                </div>
                <div class="p-8 border-b-2 border-red-100 bg-gradient-to-br from-green-50 to-green-100">
                    <!-- Tindakan Perbaikan -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-green-600 mb-2 flex items-center">
                            <i class="fas fa-wrench text-green-600 mr-2"></i>
                            Tindakan Perbaikan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="tindakan_perbaikan" rows="4" 
                                  placeholder="Jelaskan tindakan perbaikan yang dilakukan atau akan dilakukan..."
                                  class="w-full px-4 py-3 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('tindakan_perbaikan') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('tindakan_perbaikan') }}</textarea>
                        @error('tindakan_perbaikan')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Screen 2 -->
                    <div>
                        <label class="block text-sm font-bold text-green-600 mb-2 flex items-center">
                            <i class="fas fa-camera text-green-600 mr-2"></i>
                            Bukti Perbaikan (Screenshot/Foto)
                        </label>
                        <div class="border-2 border-dashed border-green-300 bg-white rounded-lg p-6 hover:border-green-500 transition-all hover:shadow-md">
                            <input type="file" name="screen_2" accept="image/*" id="screen_2"
                                   class="hidden"
                                   onchange="previewImage(this, 'preview2')">
                            <label for="screen_2" class="cursor-pointer flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-green-400 mb-2"></i>
                                <span class="text-sm text-gray-700 font-medium">Klik untuk upload gambar</span>
                                <span class="text-xs text-green-500 mt-1 font-medium">PNG, JPG, GIF hingga 2MB</span>
                            </label>
                            <div id="preview2" class="mt-4 hidden">
                                <img src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto border-2 border-green-200">
                            </div>
                        </div>
                        @error('screen_2')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 4: Pencegahan & Status -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Pencegahan & Status
                    </h2>
                </div>
                <div class="p-8 bg-gradient-to-br from-red-50 to-red-100">
                    <!-- Pencegahan -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                            <i class="fas fa-umbrella text-red-600 mr-2"></i>
                            Tindakan Pencegahan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="pencegahan" rows="4" 
                                  placeholder="Jelaskan tindakan pencegahan agar masalah tidak terulang..."
                                  class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('pencegahan') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('pencegahan') }}</textarea>
                        @error('pencegahan')
                            <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Waktu Penyelesaian -->
                        <div>
                            <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-clock text-red-600 mr-2"></i>
                                Target Penyelesaian <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" name="waktu_penyelesaian" value="{{ old('waktu_penyelesaian') }}" 
                                   class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('waktu_penyelesaian') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('waktu_penyelesaian')
                                <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                                <i class="fas fa-flag text-red-600 mr-2"></i>
                                Status <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('status') border-red-500 ring-2 ring-red-200 @enderror font-medium" 
                                    required>
                                <option value="Open" {{ old('status', 'Open') == 'Open' ? 'selected' : '' }}>🟡 Open</option>
                                <option value="Close" {{ old('status') == 'Close' ? 'selected' : '' }}>🟢 Close</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-2 flex items-center font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gradient-to-r from-red-50 to-red-100 flex justify-between items-center border-t-2 border-red-200">
                    <a href="{{ route('picas.index') }}" 
                       class="px-6 py-3 border-2 border-red-300 rounded-lg text-gray-700 font-bold hover:bg-white transition-all flex items-center shadow-sm hover:shadow-md">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 
                                   text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan PICA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection