<?php

namespace App\Exports;

use App\Models\Kanibal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KanibalExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kanibal::all();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Serial Number", "Pelanggan", "Model", "RAM", "Android", "Garansi", "Kerusakan", "Teknisi", "Perbaikan", "Perbaikan", "SNKanibal", "NO Spare Part", "Note",];
    }
}
