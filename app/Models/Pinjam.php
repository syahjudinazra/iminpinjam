<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $table = 'pinjams';
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
