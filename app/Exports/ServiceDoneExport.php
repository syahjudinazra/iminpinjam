<?php

namespace App\Exports;

use App\Models\ServiceDone;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ServiceDoneExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Serial Number", "Pelanggan", "Model", "RAM", "Android", "Garansi", "Kerusakan", "Teknisi", "Perbaikan", "SNKanibal", "NO Spare Part", "Note"];
    }
}
