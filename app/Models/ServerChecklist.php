<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServerChecklist extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',                         // ← TAMBAHAN
        'inspection_date',
        'inspector_name',
        'checklist_data',
        'total_items',
        'checked_items',
        'ok_items',
        'not_ok_items',
        'attention_items',
        'status',
        'notes'
    ];

    // Ubah tipe data otomatis
    protected $casts = [
        'checklist_data' => 'array',      // JSON jadi array otomatis
        'inspection_date' => 'date'        // String jadi tanggal otomatis
    ];

    /**
     * Relasi ke User (Inspector yang membuat checklist)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung statistik checklist
     */
    public function calculateStats()
    {
        $total = 0;
        $checked = 0;
        $ok = 0;
        $notOk = 0;
        $attention = 0;

        // Loop semua kategori dan item
        foreach ($this->checklist_data as $category) {
            foreach ($category['items'] as $item) {
                $total++;
                
                if (!is_null($item['status'])) {
                    $checked++;
                    
                    if ($item['status'] === 'ok') $ok++;
                    if ($item['status'] === 'not-ok') $notOk++;
                    if ($item['status'] === 'attention') $attention++;
                }
            }
        }

        return [
            'total' => $total,
            'checked' => $checked,
            'ok' => $ok,
            'not_ok' => $notOk,
            'attention' => $attention,
            'completion_percentage' => $total > 0 ? round(($checked / $total) * 100, 2) : 0
        ];
    }

    /**
     * Scope: Filter checklist yang sudah completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Filter checklist yang masih draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Filter berdasarkan nama inspector
     */
    public function scopeByInspector($query, $inspectorName)
    {
        return $query->where('inspector_name', 'like', "%{$inspectorName}%");
    }

    /**
     * Scope: Filter berdasarkan range tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('inspection_date', [$startDate, $endDate]);
    }

    /**
     * Scope: Filter checklist milik user tertentu
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter checklist bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('inspection_date', date('m'))
                     ->whereYear('inspection_date', date('Y'));
    }

    /**
     * Accessor: Nama inspector dari relasi user
     */
    public function getCreatedByAttribute()
    {
        return $this->user ? $this->user->name : $this->inspector_name;
    }
}