<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanibal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'serialnumber',
        'pelanggan',
        'model',
        'ram',
        'android',
        'garansi',
        'kerusakan',
        'kerusakanbawaan',
        'teknisi',
        'perbaikan',
        'snkanibal',
        'nosparepart',
        'note',
    ];
}
