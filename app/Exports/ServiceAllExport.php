<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceAllExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Service::select("id", "serialnumber", "tanggalmasuk", "tanggalkeluar", "pemilik", "status", "pelanggan", "device", "pemakaian", "kerusakan", "perbaikan", "nosparepart", "snkanibal", "teknisi", "catatan")->get();
        return Service::all();
    }

    public function headings(): array
    {
        return ["No", "Serial Number", "Tanggal Masuk", "Tanggal Keluar", "Pemilik", "Status", "Pelanggan", "Device", "Pemakaian", "Kerusakan", "Perbaikan", "No SpareParts", "SN Kanibal", "Teknisi", "Catatan"];
    }
}
