<?php

namespace App\Exports;

use App\Models\ServiceDone;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class ServiceDoneExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ServiceDone::all();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Serial Number", "Pelanggan", "Model", "RAM", "Android", "Garansi", "Kerusakan", "Teknisi", "Perbaikan", "SNKanibal", "NO Spare Part", "Note"];
    }
}
