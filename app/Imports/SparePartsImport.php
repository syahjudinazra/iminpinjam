<?php

namespace App\Imports;

use App\Models\SpareParts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class SparePartsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            SpareParts::create([
                'nospareparts'     => $row['nospareparts'],
                'tipe'    => $row['tipe'],
                'nama'    => $row['nama'],
                'quantity'    => $row['quantity'],
                'harga'    => $row['harga'],
            ]);
        }
    }
}
