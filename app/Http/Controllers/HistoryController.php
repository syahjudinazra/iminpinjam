<?php

namespace App\Http\Controllers;

use App\Exports\SparepartsActivityExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $historyLog = Activity::latest()->get();

        return view('history.index', compact('historyLog'));
    }

    public function SparePartsActivity()
    {
        $historyLogs = Activity::all();
        return Excel::download(new SparepartsActivityExport($historyLogs), 'SparepartsActivity.xlsx');
    }
}
