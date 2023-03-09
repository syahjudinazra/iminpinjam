<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use App\Exports\ExportPinjam;
use App\Models\Kembali;
use Illuminate\Support\Facades\DB;
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
        $pinjam = Pinjam::all();
        return view('pinjam.index')->with('pinjam', $pinjam);
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

        // public function moveData(Pinjam $pinjam)
        // {
        //     // Ambil data dari tabel sumber
        //     $pinjam = DB::table('pinjams')->get();

        //     // Simpan data ke tabel tujuan
        //     foreach ($pinjam as $item) {
        //         DB::table('kembalis')->insert([
        //                'tanggal'     =>   $item->tanggal,
        //                'gambar'     =>   $item->gambar,
        //                'serialnumber'   =>   $item->serialnumber,
        //                'device'   =>   $item->device,
        //                'customer'   =>   $item->customer,
        //                'telp'   =>   $item->telp,
        //                'pengirim'   =>   $item->pengirim,
        //                'kelengkapankirim'   =>   $item->kelengkapankirim,
        //                'tanggalkembali'   =>   $item->tanggalkembali,
        //                'penerima'   =>   $item->penerima,
        //                'kelengkapankembali'   =>   $item->kelengkapankembali,
        //                'status'   =>   $item->status,
        //         ]);
        //     }

        //     // Hapus data dari tabel sumber
        //     DB::table('pinjams')->truncate();

        //     // Redirect ke halaman yang diinginkan
        //     return redirect('kembali')->with('success', 'Data telah dipindahkan');
        // }

        public function moveData(Request $request)
        {
            // Validasi input
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
                // dan seterusnya
            ]);

                // Buat data baru di tabel sumber
        $newData = [
            'tanggalkembali' => $validatedData['tanggalkembali'],
            'penerima' => $validatedData['penerima'],
            'kelengkapankembali' => $validatedData['kelengkapankembali'],
            'status' => $validatedData['status'],

        ];
            $move_id = DB::table('pinjams')->insert($newData);
            // Buat data baru di tabel tujuan
            $newData = [
                'move_id' => $move_id,
                'tanggalkembali' => $validatedData['tanggalkembali'],
                'penerima' => $validatedData['penerima'],
                'kelengkapankembali' => $validatedData['kelengkapankembali'],
                'status' => $validatedData['status'],
                // dan seterusnya
            ];

            DB::table('kembalis')->insert($newData);

            DB::table('pinjams')->truncate();
            // Redirect ke halaman yang diinginkan
            return redirect('kembali')->with('success', 'Data telah dipindahkan');
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

    // Return the view with the data
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
        $pinjam = Pinjam::find($id);
        return response()->json($pinjam);
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
        // $pinjam->gambar = $request->input('gambar');
        $pinjam->serialnumber = $request->input('serialnumber');
        $pinjam->device = $request->input('device');
        $pinjam->customer = $request->input('customer');
        $pinjam->telp = $request->input('telp');
        $pinjam->pengirim = $request->input('pengirim');
        $pinjam->kelengkapankirim = $request->input('kelengkapankirim');
        $pinjam->tanggalkembali = $request->input('tanggalkembali');
        $pinjam->penerima = $request->input('penerima');
        $pinjam->kelengkapankembali = $request->input('kelengkapankembali');
        $pinjam->status = $request->input('status');

        $pinjam->save();
        return redirect('pinjam')->with('success', 'Data telah diubah');
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
