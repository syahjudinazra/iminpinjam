<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use App\Exports\ExportPinjam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pinjam = Pinjam::where('status', '0')
            ->orderBy('tanggal', 'desc')
            ->get();

            $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();

            return Datatables::of($pinjam)
                    ->addIndexColumn()
                    ->addColumn('action', function ($pinjam) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('pinjam.showDipinjam', ['id' => $pinjam->id]) . '"
                        class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                    if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                        $actionHtml .=  '<a class="dropdown-item" href="' . route('pinjam.moveDipinjam', ['id' => $pinjam->id]) . '
                                                        "><i class="fa-solid fa-paper-plane"></i> Move</a>'.
                                                        '<a class="dropdown-item" href="' . route('pinjam.editDipinjam', ['id' => $pinjam->id]) . '
                                                        "><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                                        '<a class="dropdown-item" href="' . route('pinjam.generate-pdf', ['id' => $pinjam->id]) . '"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>' .
                                                        '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-target="#deleteModal' . $pinjam->id . '"><i class="fa-solid fa-trash"></i> Delete</a>';
                                    }

                                $actionHtml .= '</div>
                                </div>';
                            }
                        }
                        $actionHtml .= '</div>';
                        return $actionHtml;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $pinjam = Pinjam::where('status', '0')
        ->orderBy('tanggal', 'desc')
        ->get();

        $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();
        return view('pinjam.Dipinjam.index', compact('pinjam', 'pinjamsDevice'));
    }

    public function kembaliPinjam(Request $request)
    {
        if ($request->ajax()) {
            $kembaliPinjam = Pinjam::where('status', '1')
            ->orderBy('tanggal', 'desc')
            ->get();

            $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();

            return Datatables::of($kembaliPinjam)
                    ->addIndexColumn()
                    ->addColumn('action', function ($kembaliPinjam) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('pinjam.showDikembalikan', ['id' => $kembaliPinjam->id]) . '"
                        class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                    if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                        $actionHtml .= '<a class="dropdown-item" href="' . route('pinjam.editDikembalikan', ['id' => $kembaliPinjam->id]) . '
                                                        "><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                                        '<a class="dropdown-item" href="' . route('pinjam.generate-pdf', ['id' => $kembaliPinjam->id]) . '"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>' .
                                                        '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-target="#deleteModal' . $kembaliPinjam->id . '"><i class="fa-solid fa-trash"></i> Delete</a>';
                                    }

                                $actionHtml .= '</div>
                                </div>';
                            }
                        }
                        $actionHtml .= '</div>';
                        return $actionHtml;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $kembaliPinjam = Pinjam::where('status', '1')
        ->orderBy('tanggal', 'desc')
        ->get();

        $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();
        return view('pinjam.Dikembalikan.index', compact('kembaliPinjam', 'pinjamsDevice'));
    }

    public function exportPinjam()
    {
        $timestamp = now()->format('d-m-Y');
        $fileName = 'DataPinjam_' . $timestamp . '.xlsx';

        return Excel::download(new ExportPinjam, $fileName);
    }

    public function generatePdf($id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pdf = pdf::loadView('pdf.generate', ['pinjam' => $pinjam]);
        return $pdf->download('test.pdf');
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
            'status' => 'max:255',
        ]);

        $pinjam = new Pinjam;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('storage/gambar/', $filename);
            $pinjam->gambar = $filename;
        }

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

        $pinjam->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function showDipinjam($id)
    {
        $pinjam = Pinjam::findOrFail($id);
        return view('pinjam.Dipinjam.view', compact('pinjam'));
    }

    public function showDikembalikan($id)
    {
        $pinjam = Pinjam::findOrFail($id);
        return view('pinjam.Dikembalikan.view', compact('pinjam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function editDipinjam(Pinjam $pinjam, $id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();
        return view('pinjam.Dipinjam.edit', compact('pinjam', 'pinjamsDevice'));
    }

    public function editDikembalikan(Pinjam $pinjam, $id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();
        return view('pinjam.Dikembalikan.edit', compact('pinjam', 'pinjamsDevice'));
    }

    public function moveDipinjam(Pinjam $pinjam, $id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pinjamsDevice =DB::table('pinjams_device')->select('name')->get();
        return view('pinjam.Dipinjam.move', compact('pinjam', 'pinjamsDevice'));
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
            'status' => 'max:255',
        ]);

        $pinjam = Pinjam::find($id);

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

        $pinjam->update();
        return redirect()->back()->with('success', 'Data berhasil diubah');
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
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
