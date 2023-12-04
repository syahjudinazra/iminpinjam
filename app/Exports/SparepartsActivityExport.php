<?php

namespace App\Exports;


use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SparepartsActivityExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $historyLogs;

    public function __construct($historyLogs)
    {
        $this->historyLogs = $historyLogs;
    }

    public function collection()
    {

        $formattedData = $this->historyLogs->map(function ($item) {
            $before = '';
            $after = '';

            if (isset($item->changes['old'])) {
                $before = json_encode($item->changes['old']);
            }

            if (isset($item->changes['attributes'])) {
                $after = json_encode($item->changes['attributes']);
            }

            return [
                $item->causer->name ?? '',
                $item->subject->nospareparts ?? '',
                $before,
                $after,
                $item->description ?? '',
                $item->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s'),
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return ["User", "No SpareParts", "Before", "After", "description", "Date Changes"];
    }
}
