<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use App\Exports\ExportPinjam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pinjam = DB::table('pinjams')->orderBy('tanggal', 'desc')
            ->where('status', '0')
            ->get();

        // $pinjam = DB::table('pinjams')->paginate(5);

        return view('pinjam.index', compact('pinjam'));
    }

    public function exportPinjam()
    {
        return Excel::download(new ExportPinjam, 'DataPinjam.xlsx');
    }

    public function search()
    {
        $pinjam = Pinjam::latest();
        if (request()->has('search')) {
            $pinjam->where('tanggal', 'Like', '%' . request()->input('search') . '%');
            $pinjam->orWhere('serialnumber', 'Like', '%' . request()->input('search') . '%');
            $pinjam->orWhere('device', 'Like', '%' . request()->input('search') . '%');
            $pinjam->orWhere('customer', 'Like', '%' . request()->input('search') . '%');
        }
        $pinjam = $pinjam->paginate(10);
        return view('pinjam.index', compact('pinjam'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);
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

        $pinjam = new Pinjam;
        $pinjam->tanggal = $request->input('tanggal');
        $pinjam->serialnumber = $request->input('serialnumber');
        $pinjam->device = $request->input('device');
        $pinjam->ram = $request->input('ram');
        $pinjam->android = $request->input('android');
        $pinjam->customer = $request->input('customer');
        $pinjam->alamat = $request->input('alamat');
        $pinjam->sales = $request->input('sales');
        $pinjam->telp = $request->input('telp');
        $pinjam->pengirim = $request->input('pengirim');
        $pinjam->kelengkapankirim = $request->input('kelengkapankirim');
        $pinjam->tanggalkembali = $request->input('tanggalkembali');
        $pinjam->penerima = $request->input('penerima');
        $pinjam->kelengkapankembali = $request->input('kelengkapankembali');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('storage/gambar/', $filename);
            $pinjam->gambar = $filename;
        }

        $pinjam->save();
        return redirect()->back()->with('success', 'Data telah ditambahkan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the data by id
        $pinjam = Pinjam::findOrFail($id);

        // // Return the view with the data
        return view('pinjam.index', compact('pinjam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function edit(Pinjam $pinjam, $id)
    {
        // $pinjam = Pinjam::find($id);
        // return response()->json($pinjam);
        $pinjam = Pinjam::findOrFail($id);
        return view('pinjam.index', compact('pinjam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $pinjam = Pinjam::find($id);
        $pinjam->tanggal = $request->input('tanggal');
        $pinjam->serialnumber = $request->input('serialnumber');
        $pinjam->device = $request->input('device');
        $pinjam->ram = $request->input('ram');
        $pinjam->android = $request->input('android');
        $pinjam->customer = $request->input('customer');
        $pinjam->alamat = $request->input('alamat');
        $pinjam->sales = $request->input('sales');
        $pinjam->telp = $request->input('telp');
        $pinjam->pengirim = $request->input('pengirim');
        $pinjam->kelengkapankirim = $request->input('kelengkapankirim');
        $pinjam->tanggalkembali = $request->input('tanggalkembali');
        $pinjam->penerima = $request->input('penerima');
        $pinjam->kelengkapankembali = $request->input('kelengkapankembali');
        $pinjam->status = $request->input('status');

        if ($request->hasFile('gambar')) {
            $destination = 'storage/gambar/' . $pinjam->gambar;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('storage/gambar/', $filename);
            $pinjam->gambar = $filename;
        }

        $pinjam->update();
        return redirect()->back()->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinjam $pinjam, $id)
    {
        // Find the data by id
        $pinjam = Pinjam::findOrFail($id);

        // Delete the pinjam
        $pinjam->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data has been deleted successfully!');
    }
}
