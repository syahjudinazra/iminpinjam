<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpareParts extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'spareparts';
    protected $primaryKey = 'id';

    protected static $logName = 'admin';
    protected $fillable = [
        'nospareparts',
        'tipe',
        'nama',
        'quantity',
        'harga',
    ];

    protected static $logAttributes= [
        'nospareparts',
        'tipe',
        'nama',
        'quantity',
        'harga',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nospareparts', 'tipe', 'nama', 'quantity', 'harga'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} data");
    }

}
