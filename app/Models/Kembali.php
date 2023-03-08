<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kembali extends Model
{
    use HasFactory;

    protected $table = 'kembalis';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal',
        'gambar',
        'serialnumber',
        'device',
        'customer',
        'telp',
        'pengirim',
        'kelengkapankirim',
        'tanggalkembali',
        'penerima',
        'kelengkapankembali',
        'status',
    ];
}
