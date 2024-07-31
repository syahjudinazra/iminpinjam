<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pengirimanService(Request $request)
    {
        if ($request->ajax()) {
            $pengirimans = Pengiriman::orderBy('created_at', 'desc');

            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showAllStocks', ['id' => $row->id]) . '"
                    class="text-decoration-none"><i class="fa-solid fa-eye"></i> Cek SN</a>';

                    $actionHtml .= '</div>';
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // If it's not an AJAX request, return the view with paginated data
        $pengirimans = Pengiriman::orderBy('created_at', 'desc');

        return view('stock.pengiriman.service.index', compact('pengirimans'));
    }

    public function create()
    {
        return view('stock.pengiriman.service.index');
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
            'serialnumber' => 'required|regex:/^\S*$/|max:255',
            'tipe' => 'required|not_in:Null',
            'sku' => 'required|not_in:Null',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255|nullable',
            'lokasi' => 'required|not_in:Null',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|array|min:1',
        ]);

        try {
            $pengirimans = new Pengiriman();
            $pengirimans->serialnumber = $request->input('serialnumber');
            $pengirimans->tipe = $request->input('tipe');
            $pengirimans->sku = $request->input('sku');
            $pengirimans->noinvoice = $request->input('noinvoice') ?? '';
            $pengirimans->tanggalmasuk = $request->input('tanggalmasuk');
            $pengirimans->tanggalkeluar = $request->input('tanggalkeluar');
            $pengirimans->pelanggan = $request->input('pelanggan');
            $pengirimans->lokasi = $request->input('lokasi');
            $pengirimans->keterangan = $request->input('keterangan') ?? '';
            $statusValues = $request->input('status');
            $statusString = implode(',', $statusValues);
            $pengirimans->status = $statusString;

            $pengirimans->save();

            return redirect()->back()->withToastSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data ' . $e->getMessage());
        }
    }

}
