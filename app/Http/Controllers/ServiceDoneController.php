<?php

namespace App\Http\Controllers;

use App\Models\ServiceDone;
use Illuminate\Http\Request;
use App\Exports\ServiceDoneExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ServiceDoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicedone = DB::table('service_dones')->orderBy('tanggal', 'desc')->paginate(10);
        return view('servicedone.index', compact('servicedone'));
    }

    // public function exportServiceDone()
    // {
    //     return Excel::download(new ServiceDoneExport, 'DataServiceDone.xlsx');
    // }

    public function exportServiceDone(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = ServiceDone::whereBetween('tanggal', [$startDate, $endDate])->get();

        return Excel::download(new ServiceDoneExport($data), 'DataServiceDone.xlsx');
    }

    public function search(Request $request) {
        $search = $request->search;
        $servicedone = ServiceDone::where('tanggal', 'LIKE', '%'.$search.'%')
        ->orWhere('serialnumber', 'LIKE', '%'.$search.'%')
        ->orWhere('pelanggan', 'LIKE', '%'.$search.'%')
        ->orWhere('model', 'LIKE', '%'.$search.'%')
        ->paginate(10);
        return view('servicedone.index', ['servicedone' => $servicedone]);
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
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceDone  $serviceDone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicedone = ServiceDone::findOrFail($id);
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
        return redirect()->back()->with('success', 'Data berhasil diubah');
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
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
