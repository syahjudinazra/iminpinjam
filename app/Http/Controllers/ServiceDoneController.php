<?php

namespace App\Http\Controllers;

use App\Models\ServiceDone;
use Illuminate\Http\Request;
use App\Exports\ServiceDoneExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ServiceDoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicedone = DB::table('service_dones')->orderBy('tanggal', 'desc')->paginate(20);
        return view('servicedone.index', compact('servicedone'));

        // return response()->json([
        //     'data' => $servicedone
        // ]);
    }

    public function exportServiceDone()
    {
        return Excel::download(new ServiceDoneExport, 'DataServiceDone.xlsx');
    }

    public function search()
    {
        $servicedone = ServiceDone::latest();
        if (request()->has('search')) {
            $servicedone->where('tanggal', 'Like', '%' . request()->input('search') . '%');
            $servicedone->orWhere('serialnumber', 'Like', '%' . request()->input('search') . '%');
            $servicedone->orWhere('pelanggan', 'Like', '%' . request()->input('search') . '%');
            $servicedone->orWhere('model', 'Like', '%' . request()->input('search') . '%');
        }
        $servicedone = $servicedone->paginate(10);
        return view('servicedone.index', compact('servicedone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pinjam.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servicedone = new ServiceDone();
        $servicedone->tanggal = $request->input('tanggal');
        $servicedone->serialnumber = $request->input('serialnumber');
        $servicedone->pelanggan = $request->input('pelanggan');
        $servicedone->model = $request->input('model');
        $servicedone->ram = $request->input('ram');
        $servicedone->android = $request->input('android');
        $servicedone->garansi = $request->input('garansi');
        $servicedone->kerusakan = $request->input('kerusakan');
        $servicedone->teknisi = $request->input('teknisi');
        $servicedone->perbaikan = $request->input('perbaikan');
        $servicedone->snkanibal = $request->input('snkanibal');
        $servicedone->nosparepart = $request->input('nosparepart');
        $servicedone->note = $request->input('note');

        $servicedone->save();
        return redirect()->back()->with('success', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceDone  $serviceDone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the data by id
        $servicedone = ServiceDone::findOrFail($id);

        // // Return the view with the data
        return view('servicedone.index', compact('servicedone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceDone  $serviceDone
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicedone = ServiceDone::findOrFail($id);
        return view('servicedone.index', compact('servicedone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceDone  $serviceDone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $servicedone = ServiceDone::find($id);
        $servicedone->tanggal = $request->input('tanggal');
        $servicedone->serialnumber = $request->input('serialnumber');
        $servicedone->pelanggan = $request->input('pelanggan');
        $servicedone->model = $request->input('model');
        $servicedone->ram = $request->input('ram');
        $servicedone->android = $request->input('android');
        $servicedone->garansi = $request->input('garansi');
        $servicedone->kerusakan = $request->input('kerusakan');
        $servicedone->teknisi = $request->input('teknisi');
        $servicedone->perbaikan = $request->input('perbaikan');
        $servicedone->snkanibal = $request->input('snkanibal');
        $servicedone->nosparepart = $request->input('nosparepart');
        $servicedone->note = $request->input('note');

        $servicedone->update();
        return redirect()->back()->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceDone  $serviceDone
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceDone $serviceDone, $id)
    {
        // Find the data by id
        $servicedone = ServiceDone::findOrFail($id);

        // Delete the servicedone
        $servicedone->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data telah dihapus');
    }
}
