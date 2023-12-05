<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicePending;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ServicePendingExport;


class ServicePendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicepending = DB::table('service_pendings')->orderBy('tanggal', 'desc')->get();
        return view('servicepending.index', compact('servicepending'));
    }

    public function exportServicePending(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = ServicePending::whereBetween('tanggal', [$startDate, $endDate])->get();

        return Excel::download(new ServicePendingExport($data), 'DataServicePending.xlsx');
    }

    public function search()
    {
        $servicepending = ServicePending::latest();
        if (request()->has('search')) {
            $servicepending->where('tanggal', 'Like', '%' . request()->input('search') . '%');
            $servicepending->orWhere('serialnumber', 'Like', '%' . request()->input('search') . '%');
            $servicepending->orWhere('pelanggan', 'Like', '%' . request()->input('search') . '%');
            $servicepending->orWhere('model', 'Like', '%' . request()->input('search') . '%');
        }
        $servicepending = $servicepending->paginate(10);
        return view('servicepending.index', compact('servicepending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicepending.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|max:255',
            'serialnumber' => 'required|max:255',
            'pelanggan' => 'required|max:255',
            'model' => 'required|max:255',
            'ram' => 'required|max:255',
            'android' => 'required|max:255',
            'garansi' => 'max:255',
            'kerusakan' => 'max:255',
            'teknisi' => 'max:255',
            'perbaikan' => 'max:255',
            'snkanibal' => 'max:255',
            'nosparepart' => 'max:255',
            'note' => 'max:255',
        ]);

        $servicepending = new ServicePending();
        $servicepending->tanggal = $request->input('tanggal');
        $servicepending->serialnumber = $request->input('serialnumber');
        $servicepending->pelanggan = $request->input('pelanggan');
        $servicepending->model = $request->input('model');
        $servicepending->ram = $request->input('ram');
        $servicepending->android = $request->input('android');
        $servicepending->garansi = $request->input('garansi');
        $servicepending->kerusakan = $request->input('kerusakan');
        $servicepending->teknisi = $request->input('teknisi');
        $servicepending->perbaikan = $request->input('perbaikan');
        $servicepending->snkanibal = $request->input('snkanibal');
        $servicepending->nosparepart = $request->input('nosparepart');
        $servicepending->note = $request->input('note');

        $servicepending->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function show(ServicePending $servicePending, $id)
    {
        // Find the data by id
        $servicepending = ServicePending::findOrFail($id);

        // // Return the view with the data
        return view('servicepending.index', compact('servicepending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicePending $servicePending, $id)
    {
        $servicepending = ServicePending::findOrFail($id);
        return view('servicepending.index', compact('servicepending'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicePending $servicePending, $id)
    {
        $request->validate([
            'tanggal' => 'required|max:255',
            'serialnumber' => 'required|max:255',
            'pelanggan' => 'required|max:255',
            'model' => 'required|max:255',
            'ram' => 'required|max:255',
            'android' => 'required|max:255',
            'garansi' => 'max:255',
            'kerusakan' => 'max:255',
            'teknisi' => 'max:255',
            'perbaikan' => 'max:255',
            'snkanibal' => 'max:255',
            'nosparepart' => 'max:255',
            'note' => 'max:255',
        ]);

        $servicepending = ServicePending::find($id);
        $servicepending->tanggal = $request->input('tanggal');
        $servicepending->serialnumber = $request->input('serialnumber');
        $servicepending->pelanggan = $request->input('pelanggan');
        $servicepending->model = $request->input('model');
        $servicepending->ram = $request->input('ram');
        $servicepending->android = $request->input('android');
        $servicepending->garansi = $request->input('garansi');
        $servicepending->kerusakan = $request->input('kerusakan');
        $servicepending->teknisi = $request->input('teknisi');
        $servicepending->perbaikan = $request->input('perbaikan');
        $servicepending->snkanibal = $request->input('snkanibal');
        $servicepending->nosparepart = $request->input('nosparepart');
        $servicepending->note = $request->input('note');

        $servicepending->update();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicePending $servicePending, $id)
    {
        $servicePending = ServicePending::findOrFail($id);

        $servicePending->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function finish(ServicePending $servicepending, $id)
    {
        $servicepending = DB::table('service_pendings')->where('id', $id)->first();
        DB::table('service_dones')->insert([
            'tanggal'     =>   $servicepending->tanggal,
            'serialnumber'   =>   $servicepending->serialnumber,
            'pelanggan'   =>   $servicepending->pelanggan,
            'model'   =>   $servicepending->model,
            'ram'   =>   $servicepending->ram,
            'android'   =>   $servicepending->android,
            'garansi'   =>   $servicepending->garansi,
            'kerusakan'   =>   $servicepending->kerusakan,
            'teknisi'   =>   $servicepending->teknisi,
            'perbaikan'   =>   $servicepending->perbaikan,
            'snkanibal'   =>   $servicepending->snkanibal,
            'nosparepart'   =>   $servicepending->nosparepart,
            'note'   =>   $servicepending->note,
        ]);

        DB::table('service_pendings')->where('id', $id)->delete();
        return redirect('/servicedone')->with('success', 'Data berhasil dipindahkan');
    }
}
