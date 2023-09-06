<?php

namespace App\Imports;

use App\Models\SpareParts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SparePartsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new SpareParts([
            'nospareparts'     => $row['nospareparts'],
            'tipe'    => $row['tipe'],
            'nama'    => $row['nama'],
            'quantity'    => $row['quantity'],
        ]);
    }
}
