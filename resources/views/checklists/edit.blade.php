@extends('checklists.layout')

@section('title', 'Edit Checklist')

@section('content')
<div x-data="checklistEditApp()" x-init="init()">
    <!-- Header -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-gray-700 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Checklist</h1>
                            <p class="text-sm text-gray-600 mt-0.5">Perbarui inspeksi ruang server</p>
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-clock"></i>
                    <span x-text="new Date().toLocaleDateString('id-ID', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Info -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-info-circle text-gray-700"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Informasi Umum</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Inspeksi *
                </label>
                <input type="date" x-model="inspectionDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Inspector *
                </label>
                <input type="text" x-model="inspectorName" placeholder="Masukkan nama inspector" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all text-sm">
            </div>
        </div>
    </div>

    <!-- Checklist Items -->
    <div class="space-y-4 mb-6">
        <template x-for="(category, catIndex) in checklist" :key="catIndex">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-900 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2" x-text="category.category"></h3>
                    <span class="bg-white bg-opacity-20 px-2.5 py-1 rounded-full text-white text-sm font-medium" x-text="category.items.length + ' item'"></span>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <template x-for="(item, itemIndex) in category.items" :key="itemIndex">
                            <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 mb-2" x-text="item.item"></p>
                                    <input 
                                        type="text" 
                                        x-model="item.note" 
                                        placeholder="Tambahkan catatan (opsional)"
                                        class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all bg-gray-50">
                                </div>
                                <div class="flex gap-2">
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'ok')"
                                        :class="item.status === 'ok' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-50'"
                                        class="w-11 h-11 rounded-lg text-sm font-medium transition-colors flex items-center justify-center"
                                        title="OK">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'not-ok')"
                                        :class="item.status === 'not-ok' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-50'"
                                        class="w-11 h-11 rounded-lg text-sm font-medium transition-colors flex items-center justify-center"
                                        title="Tidak OK">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'attention')"
                                        :class="item.status === 'attention' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-yellow-50'"
                                        class="w-11 h-11 rounded-lg text-sm font-medium transition-colors flex items-center justify-center"
                                        title="Perlu Perhatian">
                                        <i class="fas fa-exclamation"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Notes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-sticky-note text-gray-700"></i>
            </div>
            <label class="block text-sm font-semibold text-gray-900">Catatan Tambahan</label>
        </div>
        <textarea x-model="notes" rows="4" placeholder="Catatan umum tentang inspeksi..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all resize-none text-sm"></textarea>
    </div>

    <!-- Summary -->
    <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-pie text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Inspeksi</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg p-5 text-center border border-gray-200">
                <div class="text-3xl font-bold text-gray-900 mb-1" x-text="stats.total"></div>
                <div class="text-xs font-medium text-gray-600">Total Item</div>
            </div>
            <div class="bg-white rounded-lg p-5 text-center border border-gray-200">
                <div class="text-3xl font-bold text-gray-900 mb-1" x-text="stats.checked"></div>
                <div class="text-xs font-medium text-gray-600">Diperiksa</div>
            </div>
            <div class="bg-white rounded-lg p-5 text-center border border-gray-200">
                <div class="text-3xl font-bold text-green-600 mb-1" x-text="stats.ok"></div>
                <div class="text-xs font-medium text-gray-600">OK</div>
            </div>
            <div class="bg-white rounded-lg p-5 text-center border border-gray-200">
                <div class="text-3xl font-bold text-red-600 mb-1" x-text="stats.notOk"></div>
                <div class="text-xs font-medium text-gray-600">Tidak OK</div>
            </div>
            <div class="bg-white rounded-lg p-5 text-center border border-gray-200">
                <div class="text-3xl font-bold text-yellow-600 mb-1" x-text="stats.attention"></div>
                <div class="text-xs font-medium text-gray-600">Perhatian</div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-5 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-700">Progress Inspeksi</span>
                <span class="text-lg font-bold text-gray-900" x-text="stats.percentage + '%'"></span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gray-900 h-3 rounded-full transition-all duration-500" :style="`width: ${stats.percentage}%`"></div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('checklists.show', $checklist->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-6 rounded-lg text-center transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Batal
        </a>
        <button @click="updateChecklist('draft')" class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-save"></i>
            Simpan Draft
        </button>
        <button @click="updateChecklist('completed')" class="bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-check-circle"></i>
            Selesai & Simpan
        </button>
    </div>

    <!-- Loading Overlay -->
    <div x-show="loading" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 text-center shadow-xl max-w-sm mx-4">
            <div class="relative inline-block mb-4">
                <div class="w-16 h-16 border-4 border-gray-200 border-t-gray-900 rounded-full animate-spin"></div>
            </div>
            <p class="text-lg font-semibold text-gray-900 mb-1">Menyimpan Perubahan</p>
            <p class="text-sm text-gray-600">Harap tunggu sebentar...</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checklistEditApp() {
    return {
        checklistId: {{ $checklist->id }},
        inspectionDate: '{{ $checklist->inspection_date->format('Y-m-d') }}',
        inspectorName: '{{ $checklist->inspector_name }}',
        notes: '{{ $checklist->notes ?? '' }}',
        checklist: @json($checklist->checklist_data),
        loading: false,
        stats: {
            total: 0,
            checked: 0,
            ok: 0,
            notOk: 0,
            attention: 0,
            percentage: 0
        },

        init() {
            this.calculateStats();
        },

        setStatus(catIndex, itemIndex, status) {
            const item = this.checklist[catIndex].items[itemIndex];
            item.status = item.status === status ? null : status;
            this.calculateStats();
        },

        calculateStats() {
            let total = 0;
            let checked = 0;
            let ok = 0;
            let notOk = 0;
            let attention = 0;

            this.checklist.forEach(category => {
                category.items.forEach(item => {
                    total++;
                    if (item.status) {
                        checked++;
                        if (item.status === 'ok') ok++;
                        if (item.status === 'not-ok') notOk++;
                        if (item.status === 'attention') attention++;
                    }
                });
            });

            this.stats = {
                total,
                checked,
                ok,
                notOk,
                attention,
                percentage: total > 0 ? Math.round((checked / total) * 100) : 0
            };
        },

        async updateChecklist(status) {
            if (!this.inspectionDate || !this.inspectorName) {
                alert('Tanggal inspeksi dan nama inspector harus diisi!');
                return;
            }

            this.loading = true;

            try {
                const response = await fetch(`/checklists/${this.checklistId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        inspection_date: this.inspectionDate,
                        inspector_name: this.inspectorName,
                        checklist_data: JSON.stringify(this.checklist),
                        status: status,
                        notes: this.notes
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Checklist berhasil diupdate!');
                    window.location.href = `/checklists/${this.checklistId}`;
                } else {
                    alert('Gagal update checklist: ' + JSON.stringify(data.errors));
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
@endsection