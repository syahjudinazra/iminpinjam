<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Stock::all();
        return Stock::select("serialnumber", "tipe", "noinvoice", "tanggalmasuk", "tanggalkeluar", "pelanggan", "status")->get();
    }

    public function headings(): array
    {
        return ["serialnumber", "tipe", "noinvoice", "tanggalmasuk", "tanggalkeluar", "pelanggan", "status"];
    }
}
