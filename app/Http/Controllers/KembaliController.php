<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Kembali;
use Illuminate\Http\Request;
use App\Exports\ExportPinjam;
use App\Exports\ExportKembali;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class KembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pinjam = DB::table('pinjams')->orderBy('tanggal', 'desc')
            ->where('status', '1')
            ->get();

        // $pinjam = DB::table('pinjams')->paginate(10);

        return view('pinjam.index', compact('pinjam'));
    }

    public function exportKembali()
    {
        return Excel::download(new ExportKembali, 'Data Kembali.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kembali.index');
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
     * @param  \App\Models\Kembali  $kembali
     * @return \Illuminate\Http\Response
     */
    public function show(Kembali $kembali, $id)
    {
        // Find the data by id
        $kembali = Kembali::findOrFail($id);

        // Return the view with the data
        return view('kembali.index', compact('kembali'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kembali  $kembali
     * @return \Illuminate\Http\Response
     */
    public function edit(Kembali $kembali, $id)
    {
        $kembali = Kembali::find($id);
        return response()->json($kembali);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kembali  $kembali
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kembali  $kembali
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the data by id
        $kembali = Kembali::findOrFail($id);

        // Delete the kembali
        $kembali->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
