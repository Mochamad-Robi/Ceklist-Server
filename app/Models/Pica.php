<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pica extends Model
{
    protected $fillable = [
        'tanggal',
        'masalah',
        'screen',
        'akar_penyebab',
        'tindakan_perbaikan',
        'screen_2',
        'waktu_penyelesaian',
        'pencegahan',
        'pic',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_penyelesaian' => 'date',
    ];
}