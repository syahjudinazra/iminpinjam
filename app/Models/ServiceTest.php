<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTest extends Model
{
    use HasFactory;
    use SoftDeletes;
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
