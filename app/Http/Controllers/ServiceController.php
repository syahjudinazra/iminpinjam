<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Exports\ServiceExport;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('service.index');
    }
    //Pelanggan
    public function pendingPelanggan()
    {
        $pendingPelanggan = Service::where('status', 'pending')
                                    ->where('pemilik', 'customer')
                                    ->get();
        return view('service.pendingPelanggan', compact('pendingPelanggan'));
    }

    public function validasiPelanggan()
    {
        $validasiPelanggan = Service::where('status', 'validasi')
                                    ->where('pemilik', 'customer')
                                    ->get();
        return view('service.validasiPelanggan', compact('validasiPelanggan'));
    }
    public function selesaiPelanggan()
    {
        $selesaiPelanggan = Service::where('status', 'selesai')
                                    ->where('pemilik', 'customer')
                                    ->get();
        return view('service.selesaiPelanggan', compact('selesaiPelanggan'));
    }
    //Stock
    public function pendingStock()
    {
        $pendingStock = Service::where('status', 'pending')
                                ->where('pemilik', 'stock')
                                ->get();

        return view('service.pendingStock', compact('pendingStock'));
    }
    public function validasiStock()
    {
        $validasiStock = Service::where('status', 'validasi')
                                ->where('pemilik', 'stock')
                                ->get();

        return view('service.validasiStock', compact('validasiStock'));
    }
    public function selesaiStock()
    {
        $selesaiStock = Service::where('status', 'selesai')
                                ->where('pemilik', 'stock')
                                ->get();

        return view('service.selesaiStock', compact('selesaiStock'));
    }

    public function exportService(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = Service::whereBetween('tanggalmasuk', [$startDate, $endDate])->get();
        return Excel::download(new ServiceExport($data), 'DataService.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.index');
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
            'serialnumber' => 'required|max:255',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255',
            'pemilik' => 'required|array',
            'status' => 'required|array',
            'pelanggan' => 'required|max:255',
            'device' => 'required|max:255',
            'pemakaian' => 'required|max:255',
            'kerusakan' => 'required|max:255',
            'perbaikan' => 'max:255',
            'nosparepart' => 'max:255',
            'snkanibal' => 'max:255',
            'teknisi' => 'max:255',
            'catatan' => 'required|max:255',
        ]);

        $service = new Service();
        $service->serialnumber = $request->input('serialnumber');
        $service->tanggalmasuk = $request->input('tanggalmasuk');
        $service->tanggalkeluar = $request->input('tanggalkeluar');
        $service->pemilik = $request->input('pemilik');
        $service->status = $request->input('status');
        $service->pelanggan = $request->input('pelanggan');
        $service->device = $request->input('device');
        $service->pemakaian = $request->input('pemakaian');
        $service->kerusakan = $request->input('kerusakan');
        $service->perbaikan = $request->input('perbaikan');
        $service->nosparepart = $request->input('nosparepart');
        $service->snkanibal = $request->input('snkanibal');
        $service->teknisi = $request->input('teknisi');
        $service->catatan = $request->input('catatan');

        $pemilikValues = $request->input('pemilik');
        $pemilikString = implode(',', $pemilikValues);
        $service->pemilik = $pemilikString;

        $statusValues = $request->input('status');
        $statusString = implode(',', $statusValues);
        $service->status = $statusString;

        $service->save();
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('service.index', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('service.index', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255',
            'pemilik' => 'required|max:255',
            'status' => 'required|max:255',
            'pelanggan' => 'required|max:255',
            'device' => 'required|max:255',
            'pemakaian' => 'required|max:255',
            'kerusakan' => 'required|max:255',
            'perbaikan' => 'max:255',
            'nosparepart' => 'max:255',
            'snkanibal' => 'max:255',
            'teknisi' => 'max:255',
            'catatan' => 'required|max:255',
        ]);

        $service = Service::find($id);

        // Store the original 'status' value
        $originalStatus = $service->status;

        // Update the service with the new values
        $service->fill($request->all())->save();

        // Check if 'status' field is changed
        if ($originalStatus !== $service->status) {
            $statusMessage = '';

            // Check the updated 'status' value and set the appropriate message
            switch ($service->status) {
                case 'validasi':
                    $statusMessage = 'Validasi';
                    break;
                case 'selesai':
                    $statusMessage = 'Selesai';
                    break;
                case 'pending':
                    $statusMessage = 'Antrian';
                    break;
                // Add more cases for other status values as needed

                // Default case if no specific status is matched
                default:
                    $statusMessage = 'Status';
                    break;
            }

            return redirect()->back()->with('success', "Status berhasil diubah ke $statusMessage");
        } else {
            return redirect()->back()->with('success', 'Data berhasil diubah');
        }
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
