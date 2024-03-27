<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    protected $date = ['tanggalkeluar'];

    protected $fillable = [
        'serialnumber',
        'tipe',
        'noinvoice',
        'tanggalmasuk',
        'tanggalkeluar',
        'pelanggan',
        'keterangan',
        'status'
    ];
}
