@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('picas.show', $pica) }}" 
                   class="text-gray-600 hover:text-gray-900 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Edit PICA</h1>
                    <p class="text-gray-600 mt-1">Ubah informasi Problem Identification and Corrective Action</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('picas.update', $pica) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section 1: Informasi Dasar -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-info-circle mr-3"></i>
                        Informasi Dasar
                    </h2>
                </div>
                <div class="p-8 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar text-blue-600 mr-2"></i>
                                Tanggal <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $pica->tanggal->format('Y-m-d')) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('tanggal') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- PIC -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user text-blue-600 mr-2"></i>
                                PIC (Person In Charge) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="pic" value="{{ old('pic', $pica->pic) }}" 
                                   placeholder="Masukkan nama PIC"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('pic') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('pic')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Identifikasi Masalah -->
                <div class="bg-gradient-to-r from-red-600 to-orange-600 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Identifikasi Masalah
                    </h2>
                </div>
                <div class="p-8 border-b border-gray-200 bg-red-50/30">
                    <!-- Masalah -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-bug text-red-600 mr-2"></i>
                            Deskripsi Masalah <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="masalah" rows="4" 
                                  placeholder="Jelaskan masalah yang ditemukan secara detail..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('masalah') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('masalah', $pica->masalah) }}</textarea>
                        @error('masalah')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Screen 1 -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-camera text-red-600 mr-2"></i>
                            Bukti Masalah (Screenshot/Foto)
                        </label>
                        
                        @if($pica->screen)
                            <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ Storage::url($pica->screen) }}" alt="Current Screen" class="max-w-xs h-auto rounded-lg shadow-md">
                            </div>
                        @endif
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-red-500 transition-colors">
                            <input type="file" name="screen" accept="image/*" id="screen"
                                   class="hidden"
                                   onchange="previewImage(this, 'preview1')">
                            <label for="screen" class="cursor-pointer flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <span class="text-sm text-gray-600">Klik untuk upload gambar baru</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG, GIF hingga 2MB (Opsional - kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <div id="preview1" class="mt-4 hidden">
                                <img src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto">
                            </div>
                        </div>
                        @error('screen')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Akar Penyebab -->
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-search text-red-600 mr-2"></i>
                            Akar Penyebab (Root Cause) <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="akar_penyebab" rows="4" 
                                  placeholder="Analisis akar penyebab masalah menggunakan metode 5 Why, Fishbone, dll..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('akar_penyebab') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('akar_penyebab', $pica->akar_penyebab) }}</textarea>
                        @error('akar_penyebab')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Tindakan Korektif -->
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-tools mr-3"></i>
                        Tindakan Korektif
                    </h2>
                </div>
                <div class="p-8 border-b border-gray-200 bg-green-50/30">
                    <!-- Tindakan Perbaikan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-wrench text-green-600 mr-2"></i>
                            Tindakan Perbaikan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="tindakan_perbaikan" rows="4" 
                                  placeholder="Jelaskan tindakan perbaikan yang dilakukan atau akan dilakukan..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('tindakan_perbaikan') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('tindakan_perbaikan', $pica->tindakan_perbaikan) }}</textarea>
                        @error('tindakan_perbaikan')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Screen 2 -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-camera text-green-600 mr-2"></i>
                            Bukti Perbaikan (Screenshot/Foto)
                        </label>
                        
                        @if($pica->screen_2)
                            <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ Storage::url($pica->screen_2) }}" alt="Current Screen 2" class="max-w-xs h-auto rounded-lg shadow-md">
                            </div>
                        @endif
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-green-500 transition-colors">
                            <input type="file" name="screen_2" accept="image/*" id="screen_2"
                                   class="hidden"
                                   onchange="previewImage(this, 'preview2')">
                            <label for="screen_2" class="cursor-pointer flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <span class="text-sm text-gray-600">Klik untuk upload gambar baru</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG, GIF hingga 2MB (Opsional - kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <div id="preview2" class="mt-4 hidden">
                                <img src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto">
                            </div>
                        </div>
                        @error('screen_2')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 4: Pencegahan & Status -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Pencegahan & Status
                    </h2>
                </div>
                <div class="p-8 bg-purple-50/30">
                    <!-- Pencegahan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-umbrella text-purple-600 mr-2"></i>
                            Tindakan Pencegahan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="pencegahan" rows="4" 
                                  placeholder="Jelaskan tindakan pencegahan agar masalah tidak terulang..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('pencegahan') border-red-500 ring-2 ring-red-200 @enderror" 
                                  required>{{ old('pencegahan', $pica->pencegahan) }}</textarea>
                        @error('pencegahan')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Waktu Penyelesaian -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-clock text-purple-600 mr-2"></i>
                                Target Penyelesaian <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" name="waktu_penyelesaian" value="{{ old('waktu_penyelesaian', $pica->waktu_penyelesaian->format('Y-m-d')) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('waktu_penyelesaian') border-red-500 ring-2 ring-red-200 @enderror" 
                                   required>
                            @error('waktu_penyelesaian')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-flag text-purple-600 mr-2"></i>
                                Status <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('status') border-red-500 ring-2 ring-red-200 @enderror" 
                                    required>
                                <option value="Open" {{ old('status', $pica->status) == 'Open' ? 'selected' : '' }}>🟡 Open</option>
                                <option value="Close" {{ old('status', $pica->status) == 'Close' ? 'selected' : '' }}>🟢 Close</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('picas.show', $pica) }}" 
                       class="px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition-all flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 
                                   text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update PICA
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