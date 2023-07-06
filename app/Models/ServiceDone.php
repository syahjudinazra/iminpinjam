<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDone extends Model
{
    use HasFactory;
    protected $table = 'service_dones';
    protected $primaryKey = 'id';
    protected $dates = ['tanggal'];

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
