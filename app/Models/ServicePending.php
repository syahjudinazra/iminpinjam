<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePending extends Model
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
        'teknisi',
        'perbaikan',
        'snkanibal',
        'nosparepart',
        'note',
    ];
}
