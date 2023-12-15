<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    use HasFactory;
    protected $table = 'firmwares';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tipe',
        'version',
        'android',
        'flash',
        'ota',
        'kategori',
        'gambar'
    ];
}
