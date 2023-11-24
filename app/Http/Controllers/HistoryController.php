<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $historyLog = Activity::latest()->get();

        return view('history.index', compact('historyLog'));
    }
}
