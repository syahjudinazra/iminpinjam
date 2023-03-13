<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Kembali;
use Illuminate\Http\Request;
use App\Exports\ExportPinjam;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pinjam = Pinjam::all();
        // return view('pinjam.index')->with('pinjam', $pinjam);

        $pinjam = DB::table('pinjams')
        ->where('status', '0')
        ->get();

        return view('pinjam.index', compact('pinjam'));
    }

    public function exportUsers(Request $request){
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
    $pinjam = $pinjam->paginate(5);
    return view('pinjam.index',compact('pinjam'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
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
        $validatedData = $request->validate([
            'tanggal' => 'required|max:255',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'serialnumber' => 'required|max:255',
            'device' => 'required|max:255',
            'customer' => 'required|max:255',
            'telp' => 'required|max:255',
            'pengirim' => 'required|max:255',
            'kelengkapankirim' => 'required|max:255',
            'tanggalkembali' => 'max:255',
            'penerima' => 'max:255',
            'kelengkapankembali' => 'max:255',
            'status' => 'boolean',
        ]);

        $validatedData = $request->all();
        $fileName = time().$request->file('gambar')->getClientOriginalName();
        $path = $request->file('gambar')->storeAs('images', $fileName, 'public');
        $validatedData["gambar"] = '/storage/'.$path;

        Pinjam::create($validatedData);

        return redirect('pinjam')->with('success', 'Data telah ditambahkan');
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
        // $pinjam = Pinjam::find($id);
        // $pinjam->tanggal = $request->input('tanggal');
        // // $pinjam->gambar = $request->input('gambar');
        // $pinjam->serialnumber = $request->input('serialnumber');
        // $pinjam->device = $request->input('device');
        // $pinjam->customer = $request->input('customer');
        // $pinjam->telp = $request->input('telp');
        // $pinjam->pengirim = $request->input('pengirim');
        // $pinjam->kelengkapankirim = $request->input('kelengkapankirim');
        // $pinjam->tanggalkembali = $request->input('tanggalkembali');
        // $pinjam->penerima = $request->input('penerima');
        // $pinjam->kelengkapankembali = $request->input('kelengkapankembali');
        // $pinjam->status = $request->input('status');

        // // Storage::putFile('path/to', $request->file('image'));
        // $pinjam->save();

        // return redirect('pinjam')->with('success', 'Data telah diubah');
        $request->validate([
            'tanggal' => 'required|max:255',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'serialnumber' => 'required|max:255',
            'device' => 'required|max:255',
            'customer' => 'required|max:255',
            'telp' => 'required|max:255',
            'pengirim' => 'required|max:255',
            'kelengkapankirim' => 'required|max:255',
            'tanggalkembali' => 'max:255',
            'penerima' => 'max:255',
            'kelengkapankembali' => 'max:255',
            'status' => 'boolean',
        ]);

        $path = $request->file('gambar')->store('public/images');
        $pinjam = Pinjam::findOrFail($id);
        $pinjam->path = $path;
        $pinjam->save();
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
