<?php

namespace App\Imports;

use App\Models\Firmware;
use Maatwebsite\Excel\Concerns\ToModel;

class FirmwareImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Firmware([
            'tipe'     => $row[0],
            'version'    => $row[1],
            'android'    => $row[2],
            'flash'    => $row[3],
            'ota'    => $row[4],
        ]);
    }
}
