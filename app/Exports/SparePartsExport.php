<?php

namespace App\Exports;

use App\Models\SpareParts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SparePartsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SpareParts::select("nospareparts", "tipe", "nama", "quantity", "harga")->get();
        // return SpareParts::all();
    }

    public function headings(): array
    {
        return ["No SpareParts", "Tipe", "Nama", "Quantity", "Harga"];
    }
}
