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

    public function exportKanibal()
    {
        return Excel::download(new KanibalExport, 'DataKanibal.xlsx');
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
        return redirect()->back()->with('success', 'Data telah ditambahkan');
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
        return redirect()->back()->with('success', 'Data telah diubah');
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
        return redirect()->back()->with('success', 'Data telah dihapus');
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
        return redirect('/servicedone')->with('success', 'Data telah dipindahkan');
    }
}
