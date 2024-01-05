<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StockExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = Stock::all();
        return view ('stock.monitor', compact('stock'));
    }

    public function gudang()
    {
        $stockGudang = Stock::where('status', 'gudang')->get();
        return view('stock.gudang', compact('stockGudang'));
    }

    public function service()
    {
        $stockService = Stock::where('status', 'service')->get();
        return view('stock.service', compact('stockService'));
    }

    public function dipinjam()
    {
        $stockDipinjam = Stock::where('status', 'dipinjam')->get();
        return view('stock.dipinjam', compact('stockDipinjam'));
    }

    public function terjual()
    {
        $stockTerjual = Stock::where('status', 'terjual')->get();
        return view('stock.terjual', compact('stockTerjual'));
    }

    public function exportStocks()
    {
        return Excel::download(new StockExport, 'DataStock.xlsx');
    }

    public function importStocks(Request $request)
    {
        $rules = [
            'inputStocks' => 'required|mimes:xls,xlsx',
        ];

        $request->validate($rules);

        $data = Excel::toArray(new StockImport, $request->file('inputStocks'));

        $stocksData = collect(head($data))->map(function ($row) {
            return [
                'serialnumber' => $row['serialnumber'],
                'tipe' => $row['tipe'],
                'noinvoice' => $row['noinvoice'],
                'tanggalmasuk' => $row['tanggalmasuk'],
                'tanggalkeluar' => $row['tanggalkeluar'],
                'pelanggan' => $row['pelanggan'],
                'status' => $row['status'],
            ];
        })->filter(function ($stockImin) {
            return $stockImin['serialnumber'] !== null;
        })->keyBy('serialnumber')->toArray();

        foreach ($stocksData as $serialStocks => $stockImin) {
            DB::table('stocks')->updateOrInsert(
                ['serialnumber' => $serialStocks],
                $stockImin
            );
        }

        return redirect()->back()->with('success', 'Data Berhasil Diimport');
    }

    public function templateImportStock($filename)
    {
        $filePath = storage_path('app/template/' . $filename); // Adjust the path if needed

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.monitor');
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
            'tipe' => 'required|max:255',
            'noinvoice' => 'required|max:255',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255',
            'pelanggan' => 'max:255',
            'status' => 'required|array',
        ]);

        $stock = new Stock();
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->noinvoice = $request->input('noinvoice');
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');

        $statusValues = $request->input('status');
        $statusString = implode(',', $statusValues);
        $stock->status = $statusString;

        $stock->save();
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.monitor', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.monitor', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock, $id)
    {
        {
            $request->validate([
                'serialnumber' => 'required|max:255',
                'tipe' => 'required|max:255',
                'noinvoice' => 'required|max:255',
                'tanggalmasuk' => 'required|max:255',
                'tanggalkeluar' => 'max:255',
                'pelanggan' => 'max:255',
                'status' => 'required|max:255',
            ]);

            $stock = Stock::find($id);
            $stock->serialnumber = $request->input('serialnumber');
            $stock->tipe = $request->input('tipe');
            $stock->noinvoice = $request->input('noinvoice');
            $stock->tanggalmasuk = $request->input('tanggalmasuk');
            $stock->tanggalkeluar = $request->input('tanggalkeluar');
            $stock->pelanggan = $request->input('pelanggan');
            $stock->status = $request->input('status');

            $stock->update();
            return redirect()->back()->with('success', 'Data berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
