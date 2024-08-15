<?php

namespace App\Exports;

use App\Models\Pinjam;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPinjam implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Pinjam::all();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Gambar", "Serial Number", "Tipe Device", "RAM/Storage", "Android", "Customer", "Alamat", "Sales", "No Telp", "Pengirim", "Kelengkapan Kirim", "Tanggal Kembali", "Penerima", "Kelengkapan Kembali",];
    }
}
