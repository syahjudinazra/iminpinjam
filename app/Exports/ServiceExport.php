<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ServiceExport implements FromCollection, WithHeadings
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
        return ["No", "Serial Number", "Tanggal Masuk", "Tanggal Keluar", "Pemilik", "Status", "Pelanggan", "Device", "Pemakaian", "Kerusakan", "Perbaikan", "No SpareParts", "SN Kanibal", "Teknisi", "Catatan"];
    }
}
