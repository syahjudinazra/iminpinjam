<?php

namespace App\Exports;

use App\Models\Firmware;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FirmwareExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Firmware::select("tipe", "version", "android", "flash", "ota")->get();
        // return Firmware::all();
    }

    public function headings(): array
    {
        return ["Tipe", "Version", "Android", "Flash", "Ota"];
    }
}
