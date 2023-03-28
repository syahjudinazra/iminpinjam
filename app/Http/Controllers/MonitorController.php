<?php

namespace App\Http\Controllers;

use App\Models\Kanibal;
use App\Models\Monitor;
use App\Models\ServiceDone;
use Illuminate\Http\Request;
use App\Models\ServicePending;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('monitor.index', [
            'barang' => DB::table('service_dones')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'servicedone'),
            'barangsp' => DB::table('service_pendings')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'servicepending'),
            'kanibal' => DB::table('kanibals')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'kanibal')
        ]);
    }

    public function total(Request $request, ServiceDone $servicedone, ServicePending $servicepending, Kanibal $kanibal)
    {
        $servicedone = ServiceDone::count();
        $servicepending = ServicePending::count();
        $kanibal = Kanibal::count();

        return view(
            'monitor.index',
            compact('service_dones', 'service_pendings', 'kanibals')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitor  $monitor
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitor  $monitor
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monitor  $monitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitor  $monitor
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
