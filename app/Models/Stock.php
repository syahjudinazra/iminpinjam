<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

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
        'lokasi',
        'keterangan',
        'kode_pengiriman',
        'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
        'serialnumber',
        'tipe',
        'noinvoice',
        'tanggalmasuk',
        'tanggalkeluar',
        'pelanggan',
        'lokasi',
        'keterangan',
        'kode_pengiriman',
        'status'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} data");
    }

    public function activity()
    {
        return $this->morphMany('Spatie\Activitylog\Models\Activity', 'subject');
    }
}
