<?php

namespace App\Exports;

use App\Models\ServicePending;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServicePendingExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ServicePending::all();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Serial Number", "Pelanggan", "Model", "RAM", "Android", "Garansi", "Kerusakan", "Teknisi", "Perbaikan", "Perbaikan", "SNKanibal", "NO Spare Part", "Note",];
    }
}
