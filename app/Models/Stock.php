<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'serialnumber',
        'tipe',
        'noinvoice',
        'tanggalmasuk',
        'tanggalkeluar',
        'pelanggan',
        'status'
    ];
}
