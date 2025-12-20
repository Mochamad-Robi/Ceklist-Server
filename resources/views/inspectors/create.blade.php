@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Inspector</h1>
                    <p class="text-gray-600 mt-1">Kelola data inspector dengan mudah</p>
                </div>
                <button onclick="openModal()" 
                        class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Inspector
                </button>
            </div>
        </div>
        
        <!-- Alert Success -->
        @if(session('success'))
        <div class="mb-6 animate-slide-down">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-green-800">Berhasil!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Inspector</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $inspectors->count() }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-gray-700 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Aktif Hari Ini</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $inspectors->where('created_at', '>=', today())->count() }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-check text-gray-700 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $inspectors->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-gray-700 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabel Inspector -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow-sm">
            <!-- Table Header -->
            <div class="bg-gray-900 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-list-ul mr-2"></i>
                        Daftar Inspector
                    </h2>
                    <div class="text-white/80 text-sm">
                        <i class="fas fa-database mr-2"></i>
                        {{ $inspectors->count() }} Data
                    </div>
                </div>
            </div>
            
            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-700 uppercase tracking-wider">Inspector</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-700 uppercase tracking-wider">Bergabung</th>
                            <th class="text-center py-3 px-6 text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($inspectors as $index => $inspector)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center text-white text-sm font-semibold">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-semibold mr-3">
                                        {{ strtoupper(substr($inspector->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $inspector->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ str_pad($inspector->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-envelope mr-2 text-gray-400 text-sm"></i>
                                    <span class="text-sm">{{ $inspector->email }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900">{{ $inspector->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $inspector->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="editInspector({{ $inspector->id }}, '{{ addslashes($inspector->name) }}', '{{ $inspector->email }}')" 
                                            class="w-9 h-9 bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors flex items-center justify-center">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <form action="{{ route('inspectors.destroy', $inspector->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus inspector {{ $inspector->name }}?')" 
                                                class="w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Inspector</h3>
                                    <p class="text-gray-500 text-sm mb-4">Mulai tambahkan inspector untuk sistem Anda</p>
                                    <button onclick="openModal()" class="px-5 py-2.5 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                        <i class="fas fa-plus mr-2"></i>Tambah Inspector Sekarang
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Inspector -->
<div id="inspectorModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-8 max-w-lg w-full transform transition-all scale-95 opacity-0 modal-content shadow-xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 id="modalTitle" class="text-2xl font-bold text-gray-900">Tambah Inspector</h2>
                <p class="text-gray-600 text-sm mt-1">Lengkapi form di bawah ini</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                <i class="fas fa-times text-gray-600"></i>
            </button>
        </div>
        
        <form id="inspectorForm" action="{{ route('inspectors.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="">
            <input type="hidden" id="inspectorId" name="inspector_id" value="">
            
            <!-- Nama Field -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user mr-1 text-gray-400"></i>
                    Nama Lengkap
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-2 focus:ring-gray-200 transition-all @error('name') border-red-500 @enderror" 
                       placeholder="Masukkan nama lengkap inspector"
                       required>
                @error('name')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror
            </div>
            
            <!-- Email Field -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-1 text-gray-400"></i>
                    Alamat Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-2 focus:ring-gray-200 transition-all @error('email') border-red-500 @enderror" 
                       placeholder="contoh@email.com"
                       required>
                @error('email')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror
            </div>
            
            <!-- Password Field -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1 text-gray-400"></i>
                    Password
                </label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-2 focus:ring-gray-200 transition-all @error('password') border-red-500 @enderror" 
                       placeholder="Minimal 6 karakter">
                <p class="text-sm text-gray-500 mt-1" id="passwordHint">
                    <i class="fas fa-info-circle mr-1"></i>
                    <span id="passwordHintText"></span>
                </p>
                @error('password')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
                @enderror
            </div>
            
            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal()" 
                        class="flex-1 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-5 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-semibold transition-colors">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-down {
    animation: slideDown 0.3s ease-out;
}

#inspectorModal.flex .modal-content {
    animation: modalShow 0.2s ease-out forwards;
}

@keyframes modalShow {
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function openModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Inspector';
    document.getElementById('inspectorForm').action = '{{ route("inspectors.store") }}';
    document.getElementById('methodField').value = '';
    document.getElementById('inspectorId').value = '';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('password').required = true;
    document.getElementById('passwordHintText').textContent = 'Minimal 6 karakter';
    
    const modal = document.getElementById('inspectorModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function editInspector(id, name, email) {
    document.getElementById('modalTitle').textContent = 'Edit Inspector';
    document.getElementById('inspectorForm').action = `/inspectors/${id}`;
    document.getElementById('methodField').value = 'PUT';
    document.getElementById('inspectorId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = '';
    document.getElementById('password').required = false;
    document.getElementById('passwordHintText').textContent = 'Kosongkan jika tidak ingin mengubah password';
    
    const modal = document.getElementById('inspectorModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('inspectorModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal on outside click
document.getElementById('inspectorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Auto show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        @if(old('inspector_id'))
            editInspector({{ old('inspector_id') }}, '{{ old('name') }}', '{{ old('email') }}');
        @else
            openModal();
        @endif
    });
@endif
</script>
@endsection