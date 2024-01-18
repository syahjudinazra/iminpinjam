<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $date = ['tanggalkeluar'];

    protected $fillable = [
        'serialnumber',
        'tanggalmasuk',
        'tanggalkeluar',
        'pemilik',
        'status',
        'pelanggan',
        'device',
        'pemakaian',
        'kerusakan',
        'perbaikan',
        'nosparepart',
        'snkanibal',
        'teknisi',
        'catatan',
    ];
}
