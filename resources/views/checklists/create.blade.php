@extends('checklists.layout')

@section('title', 'Buat Checklist Baru')

@section('content')
<div x-data="checklistApp()" x-init="init()">
    <!-- Header with Breadcrumb -->
    <div class="mb-6 bg-white rounded-xl shadow-lg border-2 border-red-100 p-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('checklists.index') }}" class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-red-400 text-xs mx-2"></i>
                        <span class="text-sm font-bold text-gray-900">Buat Checklist</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Buat Checklist Baru
                    </h1>
                    <p class="text-sm text-red-600 font-medium">
                        Inspeksi ruang server
                    </p>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-200 rounded-lg px-4 py-2">
                    <p class="text-sm text-red-700 font-bold">
                        <i class="fas fa-info-circle mr-1"></i>
                        Template: Server Room Inspection
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Info -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 p-4 mb-6 rounded-r-xl shadow-md">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-900 font-bold">Tips Pengisian Checklist</p>
                <p class="text-sm text-blue-800 mt-1">Pastikan semua item diperiksa dengan teliti. Gunakan status "Perlu Perhatian" untuk item yang memerlukan tindak lanjut.</p>
            </div>
        </div>
    </div>

    <!-- Form Info -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 p-6 mb-6">
        <div class="flex items-center mb-4">
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-2 mr-3 border border-red-200">
                <i class="fas fa-info-circle text-red-600"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Informasi Umum</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Tanggal Inspeksi *
                </label>
                <input type="date" x-model="inspectionDate" class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Nama Inspector *
                </label>
                <input type="text" x-model="inspectorName" placeholder="Masukkan nama inspector" class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Lokasi
                </label>
                <input type="text" x-model="location" placeholder="Lokasi ruang server (opsional)" class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-red-600 mb-2">
                    Waktu Inspeksi
                </label>
                <input type="time" x-model="inspectionTime" class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
            </div>
        </div>
    </div>

    <!-- Progress Bar Sticky -->
    <div class="sticky top-0 z-40 bg-white shadow-lg rounded-xl border-2 border-red-100 p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center">
                <i class="fas fa-tasks text-red-600 mr-2"></i>
                <span class="text-sm font-bold text-gray-900">Progress Pengisian</span>
            </div>
            <span class="text-sm font-bold text-red-600" x-text="stats.percentage + '%'"></span>
        </div>
        <div class="w-full bg-red-100 rounded-full h-2.5 border border-red-200">
            <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full transition-all duration-500 shadow-sm" :style="`width: ${stats.percentage}%`"></div>
        </div>
        <div class="flex justify-between mt-2 text-xs">
            <span class="text-gray-700 font-medium"><i class="fas fa-check-circle text-green-600"></i> <span x-text="stats.checked"></span> dari <span x-text="stats.total"></span> item</span>
            <span x-show="stats.checked === stats.total && stats.total > 0" class="text-green-600 font-bold">
                <i class="fas fa-trophy"></i> Selesai!
            </span>
        </div>
    </div>

    <!-- Checklist Items -->
    <div class="space-y-4 mb-6">
        <template x-for="(category, catIndex) in checklist" :key="catIndex">
            <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-base font-bold text-white flex items-center">
                        <i class="fas fa-folder-open mr-2"></i>
                        <span x-text="category.category"></span>
                    </h3>
                    <span class="bg-white bg-opacity-20 text-white text-xs font-bold px-3 py-1 rounded-full border border-white border-opacity-30">
                        <span x-text="category.items.filter(i => i.status).length"></span> / <span x-text="category.items.length"></span>
                    </span>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <template x-for="(item, itemIndex) in category.items" :key="itemIndex">
                            <div class="flex items-start gap-4 p-4 border-2 border-red-100 rounded-lg hover:bg-red-50 transition-all"
                                 :class="item.status ? 'border-l-4' : ''"
                                 :style="item.status === 'ok' ? 'border-left-color: #10b981' : item.status === 'not-ok' ? 'border-left-color: #ef4444' : item.status === 'attention' ? 'border-left-color: #f59e0b' : ''">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 flex items-center justify-center">
                                        <span class="text-sm font-bold text-red-600" x-text="itemIndex + 1"></span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 mb-2" x-text="item.item"></p>
                                    <input 
                                        type="text" 
                                        x-model="item.note" 
                                        placeholder="Tambahkan catatan (opsional)"
                                        class="mt-2 w-full text-sm border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                                    <div x-show="item.status" class="mt-2">
                                        <span :class="{
                                            'bg-green-100 text-green-700 border-green-200': item.status === 'ok',
                                            'bg-red-100 text-red-700 border-red-200': item.status === 'not-ok',
                                            'bg-yellow-100 text-yellow-700 border-yellow-200': item.status === 'attention'
                                        }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border-2">
                                            <i :class="{
                                                'fa-check-circle': item.status === 'ok',
                                                'fa-times-circle': item.status === 'not-ok',
                                                'fa-exclamation-triangle': item.status === 'attention'
                                            }" class="fas mr-1"></i>
                                            <span x-text="item.status === 'ok' ? 'OK' : item.status === 'not-ok' ? 'Tidak OK' : 'Perlu Perhatian'"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-wrap justify-end">
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'ok')"
                                        :class="item.status === 'ok' ? 'bg-green-600 text-white shadow-lg' : 'bg-gradient-to-br from-green-50 to-green-100 text-green-700 hover:from-green-100 hover:to-green-200 border-2 border-green-200'"
                                        class="px-3 py-2 rounded-lg text-sm font-bold transition-all"
                                        title="OK">
                                        <i class="fas fa-check"></i>
                                        <span class="ml-1 hidden sm:inline">OK</span>
                                    </button>
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'not-ok')"
                                        :class="item.status === 'not-ok' ? 'bg-red-600 text-white shadow-lg' : 'bg-gradient-to-br from-red-50 to-red-100 text-red-700 hover:from-red-100 hover:to-red-200 border-2 border-red-200'"
                                        class="px-3 py-2 rounded-lg text-sm font-bold transition-all"
                                        title="Tidak OK">
                                        <i class="fas fa-times"></i>
                                        <span class="ml-1 hidden sm:inline">Tidak</span>
                                    </button>
                                    <button 
                                        @click="setStatus(catIndex, itemIndex, 'attention')"
                                        :class="item.status === 'attention' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-700 hover:from-yellow-100 hover:to-yellow-200 border-2 border-yellow-200'"
                                        class="px-3 py-2 rounded-lg text-sm font-bold transition-all"
                                        title="Perlu Perhatian">
                                        <i class="fas fa-exclamation"></i>
                                        <span class="ml-1 hidden sm:inline">Perhatian</span>
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
    <div class="bg-white rounded-xl shadow-lg border-2 border-red-100 p-6 mb-6">
        <div class="flex items-center mb-3">
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-2 mr-3 border border-red-200">
                <i class="fas fa-sticky-note text-red-600"></i>
            </div>
            <label class="block text-sm font-bold text-gray-900">Catatan Tambahan</label>
        </div>
        <textarea x-model="notes" rows="4" placeholder="Catatan umum tentang inspeksi..." class="w-full border-2 border-red-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm"></textarea>
    </div>

    <!-- Summary -->
    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-lg border-2 border-red-200 p-6 mb-6">
        <div class="flex items-center mb-4">
            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-lg p-2 mr-3 shadow-md">
                <i class="fas fa-chart-pie text-white"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Ringkasan Inspeksi</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center bg-white rounded-lg p-4 shadow-md border-2 border-red-200">
                <div class="text-3xl font-bold text-gray-900" x-text="stats.total"></div>
                <div class="text-sm text-red-600 mt-1 font-bold">Total Item</div>
            </div>
            <div class="text-center bg-white rounded-lg p-4 shadow-md border-2 border-red-200">
                <div class="text-3xl font-bold text-gray-900" x-text="stats.checked"></div>
                <div class="text-sm text-red-600 mt-1 font-bold">Diperiksa</div>
            </div>
            <div class="text-center bg-white rounded-lg p-4 shadow-md border-2 border-green-200">
                <div class="text-3xl font-bold text-green-600" x-text="stats.ok"></div>
                <div class="text-sm text-green-600 mt-1 font-bold">OK</div>
            </div>
            <div class="text-center bg-white rounded-lg p-4 shadow-md border-2 border-red-200">
                <div class="text-3xl font-bold text-red-600" x-text="stats.notOk"></div>
                <div class="text-sm text-red-600 mt-1 font-bold">Tidak OK</div>
            </div>
            <div class="text-center bg-white rounded-lg p-4 shadow-md border-2 border-yellow-200">
                <div class="text-3xl font-bold text-yellow-600" x-text="stats.attention"></div>
                <div class="text-sm text-yellow-600 mt-1 font-bold">Perhatian</div>
            </div>
        </div>
        <div class="mt-6 bg-white rounded-lg p-4 shadow-md border-2 border-red-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-red-600">Progress Keseluruhan</span>
                <span class="text-lg font-bold text-red-600" x-text="stats.percentage + '%'"></span>
            </div>
            <div class="w-full bg-red-100 rounded-full h-3 overflow-hidden border border-red-200">
                <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full transition-all duration-500 shadow-sm" :style="`width: ${stats.percentage}%`"></div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="sticky bottom-0 bg-white border-t-4 border-red-500 shadow-xl rounded-t-xl p-4 -mx-4 md:mx-0 md:rounded-xl">
        <div class="flex flex-col sm:flex-row gap-3">
            <button @click="saveChecklist('draft')" class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-900 font-bold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center border-2 border-gray-300">
                <i class="fas fa-save mr-2"></i>
                Simpan Draft
            </button>
            <button @click="saveChecklist('completed')" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>
                Selesai & Simpan
            </button>
        </div>
        <p class="text-xs text-red-600 text-center mt-3 font-medium">
            <i class="fas fa-info-circle mr-1"></i>
            Pastikan semua data telah diisi dengan benar sebelum menyimpan
        </p>
    </div>

    <!-- Loading Overlay -->
    <div x-show="loading" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 text-center shadow-2xl border-4 border-red-500">
            <i class="fas fa-spinner fa-spin text-4xl text-red-600 mb-4"></i>
            <p class="text-gray-900 font-bold text-lg">Menyimpan checklist...</p>
            <p class="text-red-600 text-sm mt-2 font-medium">Mohon tunggu sebentar</p>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    [x-cloak] { 
        display: none !important; 
    }
    
    html {
        scroll-behavior: smooth;
    }
</style>

@push('scripts')
<script>
function checklistApp() {
    return {
        inspectionDate: new Date().toISOString().split('T')[0],
        inspectorName: '',
        location: '',
        inspectionTime: new Date().toTimeString().slice(0, 5),
        notes: '',
        checklist: @json($template),
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

        async saveChecklist(status) {
            if (!this.inspectionDate || !this.inspectorName) {
                alert('Tanggal inspeksi dan nama inspector harus diisi!');
                return;
            }

            this.loading = true;

            try {
                const response = await fetch('{{ route("checklists.store") }}', {
                    method: 'POST',
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
                    alert('Checklist berhasil disimpan!');
                    window.location.href = '{{ route("checklists.index") }}';
                } else {
                    alert('Gagal menyimpan checklist: ' + JSON.stringify(data.errors));
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