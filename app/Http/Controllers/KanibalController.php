<?php

namespace App\Http\Controllers;

use App\Exports\KanibalExport;
use App\Models\Kanibal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KanibalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kanibal = DB::table('kanibals')->orderBy('tanggal', 'desc')->paginate(10);
        return view('kanibal.index', compact('kanibal'));
    }

    // public function exportKanibal()
    // {
    //     return Excel::download(new KanibalExport, 'DataKanibal.xlsx');
    // }

    public function exportKanibal(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = Kanibal::whereBetween('tanggal', [$startDate, $endDate])->get();

        return Excel::download(new KanibalExport($data), 'DataServiceDone.xlsx');
    }


    public function search()
    {
        $kanibal = Kanibal::latest();
        if (request()->has('search')) {
            $kanibal->where('tanggal', 'Like', '%' . request()->input('search') . '%');
            $kanibal->orWhere('serialnumber', 'Like', '%' . request()->input('search') . '%');
            $kanibal->orWhere('pelanggan', 'Like', '%' . request()->input('search') . '%');
            $kanibal->orWhere('model', 'Like', '%' . request()->input('search') . '%');
        }
        $kanibal = $kanibal->paginate(10);
        return view('kanibal.index', compact('kanibal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kanibal.index');
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

        $kanibal = new Kanibal();
        $kanibal->tanggal = $request->input('tanggal');
        $kanibal->serialnumber = $request->input('serialnumber');
        $kanibal->pelanggan = $request->input('pelanggan');
        $kanibal->model = $request->input('model');
        $kanibal->ram = $request->input('ram');
        $kanibal->android = $request->input('android');
        $kanibal->garansi = $request->input('garansi');
        $kanibal->kerusakan = $request->input('kerusakan');
        $kanibal->teknisi = $request->input('teknisi');
        $kanibal->perbaikan = $request->input('perbaikan');
        $kanibal->snkanibal = $request->input('snkanibal');
        $kanibal->nosparepart = $request->input('nosparepart');
        $kanibal->note = $request->input('note');

        $kanibal->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kanibal  $kanibal
     * @return \Illuminate\Http\Response
     */
    public function show(Kanibal $kanibal, $id)
    {
        // Find the data by id
        $kanibal = kanibal::findOrFail($id);

        // // Return the view with the data
        return view('kanibal.index', compact('kanibal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kanibal  $kanibal
     * @return \Illuminate\Http\Response
     */
    public function edit(Kanibal $kanibal, $id)
    {
        $kanibal = kanibal::findOrFail($id);
        return view('kanibal.index', compact('kanibal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kanibal  $kanibal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kanibal $kanibal, $id)
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

        $kanibal = Kanibal::find($id);
        $kanibal->tanggal = $request->input('tanggal');
        $kanibal->serialnumber = $request->input('serialnumber');
        $kanibal->pelanggan = $request->input('pelanggan');
        $kanibal->model = $request->input('model');
        $kanibal->ram = $request->input('ram');
        $kanibal->android = $request->input('android');
        $kanibal->garansi = $request->input('garansi');
        $kanibal->kerusakan = $request->input('kerusakan');
        $kanibal->teknisi = $request->input('teknisi');
        $kanibal->perbaikan = $request->input('perbaikan');
        $kanibal->snkanibal = $request->input('snkanibal');
        $kanibal->nosparepart = $request->input('nosparepart');
        $kanibal->note = $request->input('note');

        $kanibal->update();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kanibal  $kanibal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kanibal $kanibal, $id)
    {
        // Find the data by id
        $kanibal = Kanibal::findOrFail($id);

        // Delete the kanibal
        $kanibal->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function finish(Kanibal $kanibal, $id)
    {

        // Ambil data dari tabel sumber
        $kanibal = DB::table('kanibals')->where('id', $id)->first();

        // Simpan data ke tabel tujuan
        DB::table('service_dones')->insert([
            'tanggal'     =>   $kanibal->tanggal,
            'serialnumber'   =>   $kanibal->serialnumber,
            'pelanggan'   =>   $kanibal->pelanggan,
            'model'   =>   $kanibal->model,
            'ram'   =>   $kanibal->ram,
            'android'   =>   $kanibal->android,
            'garansi'   =>   $kanibal->garansi,
            'kerusakan'   =>   $kanibal->kerusakan,
            'teknisi'   =>   $kanibal->teknisi,
            'perbaikan'   =>   $kanibal->perbaikan,
            'snkanibal'   =>   $kanibal->snkanibal,
            'nosparepart'   =>   $kanibal->nosparepart,
            'note'   =>   $kanibal->note,
        ]);

        // Hapus data dari tabel sumber
        DB::table('kanibals')->where('id', $id)->delete();

        // Redirect ke halaman yang diinginkan
        return redirect('/servicedone')->with('success', 'Data berhasil dipindahkan');
    }
}
