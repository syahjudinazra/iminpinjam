<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id';
    protected $date = ['tanggalkeluar'];

    protected $fillable = [
        'serialnumber',
        'tipe',
        'noinvoice',
        'tanggalmasuk',
        'tanggalkeluar',
        'pelanggan',
        'lokasi',
        'keterangan',
        'status'
    ];
}
