<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpareParts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'spareparts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nospareparts',
        'tipe',
        'nama',
        'quantity',
    ];
}
