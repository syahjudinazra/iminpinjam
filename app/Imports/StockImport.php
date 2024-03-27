<?php

namespace App\Imports;

use App\Models\Stock;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'serialnumber' => $row['serialnumber'],
            'tipe' => $row['tipe'],
            'noinvoice' => $row['noinvoice'],
            'tanggalmasuk' => $row['tanggalmasuk'],
            'tanggalkeluar' => $row['tanggalkeluar'],
            'pelanggan' => $row['pelanggan'],
            'keterangan' => $row['keterangan'],
            'status' => $row['status'],
        ]);
    }
}
