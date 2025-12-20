<?php

namespace App\Http\Controllers;

use App\Models\ServerChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServerChecklistController extends Controller
{
    /**
     * Tampilkan semua checklist (Halaman List)
     */
    public function index(Request $request)
    {
        $query = ServerChecklist::query();

        // Filter by status (draft atau completed)
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by inspector
        if ($request->has('inspector')) {
            $query->byInspector($request->inspector);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        // Ambil data dengan pagination
        $checklists = $query->orderBy('inspection_date', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(15);

        return view('checklists.index', compact('checklists'));
    }

    /**
     * Tampilkan form create checklist baru
     */
    public function create()
    {
        $template = $this->getDefaultTemplate();
        return view('checklists.create', compact('template'));
    }

    /**
     * Simpan checklist baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'inspection_date' => 'required|date',
            'inspector_name' => 'required|string|max:255',
            'checklist_data' => 'required|json',
            'status' => 'in:draft,completed',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Decode JSON data
        $checklistData = json_decode($request->checklist_data, true);
        
        // Buat checklist baru
        $checklist = new ServerChecklist();
        $checklist->inspection_date = $request->inspection_date;
        $checklist->inspector_name = $request->inspector_name;
        $checklist->checklist_data = $checklistData;
        $checklist->status = $request->status ?? 'draft';
        $checklist->notes = $request->notes;

        // Hitung statistik
        $stats = $checklist->calculateStats();
        $checklist->total_items = $stats['total'];
        $checklist->checked_items = $stats['checked'];
        $checklist->ok_items = $stats['ok'];
        $checklist->not_ok_items = $stats['not_ok'];
        $checklist->attention_items = $stats['attention'];

        // Simpan ke database
        $checklist->save();

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil disimpan',
            'data' => $checklist
        ], 201);
    }

    /**
     * Tampilkan detail checklist
     */
    public function show($id)
    {
        $checklist = ServerChecklist::findOrFail($id);
        $stats = $checklist->calculateStats();
        
        return view('checklists.show', compact('checklist', 'stats'));
    }

    /**
     * Tampilkan form edit checklist
     */
    public function edit($id)
    {
        $checklist = ServerChecklist::findOrFail($id);
        return view('checklists.edit', compact('checklist'));
    }

    /**
     * Update checklist
     */
    public function update(Request $request, $id)
    {
        $checklist = ServerChecklist::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'inspection_date' => 'required|date',
            'inspector_name' => 'required|string|max:255',
            'checklist_data' => 'required|json',
            'status' => 'in:draft,completed',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $checklistData = json_decode($request->checklist_data, true);
        
        // Update data
        $checklist->inspection_date = $request->inspection_date;
        $checklist->inspector_name = $request->inspector_name;
        $checklist->checklist_data = $checklistData;
        $checklist->status = $request->status ?? 'draft';
        $checklist->notes = $request->notes;

        // Recalculate stats
        $stats = $checklist->calculateStats();
        $checklist->total_items = $stats['total'];
        $checklist->checked_items = $stats['checked'];
        $checklist->ok_items = $stats['ok'];
        $checklist->not_ok_items = $stats['not_ok'];
        $checklist->attention_items = $stats['attention'];

        $checklist->save();

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil diupdate',
            'data' => $checklist
        ]);
    }

    /**
     * Hapus checklist
     */
    public function destroy($id)
    {
        $checklist = ServerChecklist::findOrFail($id);
        $checklist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil dihapus'
        ]);
    }
    /**
     * Export checklist ke CSV
     */
    public function exportCsv($id)
    {
        $checklist = ServerChecklist::findOrFail($id);
        $stats = $checklist->calculateStats();

        $filename = 'checklist-ruang-server-' . $checklist->inspection_date->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($checklist, $stats) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Server Room Checklist']);
            fputcsv($file, ['Tanggal', $checklist->inspection_date->format('d/m/Y')]);
            fputcsv($file, ['Inspector', $checklist->inspector_name]);
            fputcsv($file, []);
            
            // Data header
            fputcsv($file, ['Kategori', 'Item', 'Status', 'Catatan']);
            
            // Data
            foreach ($checklist->checklist_data as $category) {
                foreach ($category['items'] as $item) {
                    $status = match($item['status']) {
                        'ok' => 'OK',
                        'not-ok' => 'Tidak OK',
                        'attention' => 'Perlu Perhatian',
                        default => 'Belum Diperiksa'
                    };
                    
                    fputcsv($file, [
                        $category['category'],
                        $item['item'],
                        $status,
                        $item['note'] ?? ''
                    ]);
                }
            }
            
            // Summary
            fputcsv($file, []);
            fputcsv($file, ['Ringkasan']);
            fputcsv($file, ['Total Item', $stats['total']]);
            fputcsv($file, ['Sudah Diperiksa', $stats['checked']]);
            fputcsv($file, ['OK', $stats['ok']]);
            fputcsv($file, ['Tidak OK', $stats['not_ok']]);
            fputcsv($file, ['Perlu Perhatian', $stats['attention']]);
            fputcsv($file, ['Persentase Selesai', $stats['completion_percentage'] . '%']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function report(Request $request)
{
    $query = ServerChecklist::query();
    
    // Filter by date range
    if ($request->filled('start_date')) {
        $query->whereDate('inspection_date', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('inspection_date', '<=', $request->end_date);
    }
    
    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    // Get paginated data
    $checklists = $query->latest('inspection_date')->paginate(15);
    
    // Statistics
    $completedCount = ServerChecklist::where('status', 'completed')->count();
    $draftCount = ServerChecklist::where('status', 'draft')->count();
    $thisMonthCount = ServerChecklist::whereMonth('inspection_date', date('m'))
        ->whereYear('inspection_date', date('Y'))
        ->count();
    
    // Activity counts
    $todayCount = ServerChecklist::whereDate('inspection_date', today())->count();
    $weekCount = ServerChecklist::whereBetween('inspection_date', [
        now()->startOfWeek(), 
        now()->endOfWeek()
    ])->count();
    
    // Monthly data for trend (last 6 months)
    $monthlyData = [];
    $monthlyLabels = [];
    
    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $count = ServerChecklist::whereYear('inspection_date', $date->year)
            ->whereMonth('inspection_date', $date->month)
            ->count();
        
        $monthlyData[] = $count;
        $monthlyLabels[] = $date->format('M Y');
    }
    
    return view('checklists.report', compact(
        'checklists',
        'completedCount',
        'draftCount',
        'thisMonthCount',
        'todayCount',
        'weekCount',
        'monthlyData',
        'monthlyLabels'
    ));
}
    /**
     * Get template default checklist
     */
   private function getDefaultTemplate()
{
    return [
        [
            'category' => 'Perangkat dan Rak',
            'items' => [
                ['item' => 'Memastikan perangkat di rak dalam kondisi baik', 'status' => null, 'note' => ''],
                ['item' => 'Memastikan tidak ada benda asing di dalam rak server', 'status' => null, 'note' => ''],
                ['item' => 'Memastikan pintu rak server terkunci', 'status' => null, 'note' => ''],
                ['item' => 'Memastikan ruangan steril dari barang yang tidak ada hubungannya dengan perangkat', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Keamanan Ruangan',
            'items' => [
                ['item' => 'Memastikan tidak ada kebocoran ke dalam ruangan', 'status' => null, 'note' => ''],
                ['item' => 'CCTV aktif & merekam', 'status' => null, 'note' => ''],
                ['item' => 'Ruang server bersih & bebas debu', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Kelistrikan',
            'items' => [
                ['item' => 'Memastikan UPS nyala', 'status' => null, 'note' => ''],
                ['item' => 'UPS normal (no alarm)', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Sistem Pendingin',
            'items' => [
                ['item' => 'Suhu ruangan 22°C', 'status' => null, 'note' => ''],
                ['item' => 'Pastikan ruangan server terkunci', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Status Server dan Perangkat',
            'items' => [
                ['item' => 'Indikator server normal', 'status' => null, 'note' => ''],
                ['item' => 'Switch/router/firewall normal', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Sistem dan Aplikasi',
            'items' => [
                ['item' => 'Memastikan Synolog + Qnap Berjalan dengan baik', 'status' => null, 'note' => '']
            ]
        ],
        [
            'category' => 'Koneksi Internet',
            'items' => [
                ['item' => 'Cek Kondisi Jaringan Indihome', 'status' => null, 'note' => ''],
                ['item' => 'Cek Kondisi Jaringan Cyber-K', 'status' => null, 'note' => '']
            ]
        ]
    ];
}
}