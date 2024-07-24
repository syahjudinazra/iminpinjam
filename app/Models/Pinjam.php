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
        'serialnumber',
        'device',
        'ram',
        'android',
        'customer',
        'alamat',
        'sales',
        'telp',
        'pengirim',
        'kelengkapankirim',
        'tanggalkembali',
        'penerima',
        'kelengkapankembali',
        'status',
    ];
}
