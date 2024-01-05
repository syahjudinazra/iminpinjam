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
            'status' => $row['status'],
        ]);

            // Check if 'tanggalkeluar' exists and is not empty
    if (isset($row['tanggalkeluar']) && !empty($row['tanggalkeluar'])) {
        // Handle 'tanggalkeluar' when it's not empty
        $data['tanggalkeluar'] = Carbon::createFromFormat('d-m-Y', $row['tanggalkeluar']);
    } else {
        // Set 'tanggalkeluar' as null when it's empty or not provided
        $data['tanggalkeluar'] = null;
    }

    return new Stock($data);
    }
}
