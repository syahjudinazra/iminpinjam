<?php

namespace App\Exports;

use App\Models\Kembali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportKembali implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kembali::all();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Gambar", "Serial Number", "Tpe Device", "Customer", "No Telp", "Pengirim", "Kelengkapan Kirim", "tanggalkembali", "penerima", "kelengkapankembali", ];
    }
}
