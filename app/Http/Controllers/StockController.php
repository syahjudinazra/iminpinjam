<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Exports\StockExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusValues = ['Gudang', 'Service', 'Dipinjam', 'Terjual'];

        $stockCounts = Stock::whereIn('status', $statusValues)
            ->groupBy('status', 'tipe')
            ->selectRaw('status, tipe, COUNT(*) as count')
            ->get();

        $countByStatus = [];

        foreach ($stockCounts as $count) {
            $countByStatus[$count->status][$count->tipe] = $count->count;
        }

        $stock = Stock::all();
        return view('stock.monitor', compact('stock', 'countByStatus'));
    }

    public function checkSerialNumbers(Request $request)
    {
        $serialNumbers = preg_split("/\\r\\n|\\r|\\n/", $request->input('serialnumber'));
        $validationResults = [];

        foreach ($serialNumbers as $serialNumber) {
            // Perform your validation logic here to check if the serial number exists in the database
            $stock = Stock::where('serialnumber', $serialNumber)->first();

            if ($stock) {
                // If the stock with the given serial number exists, fetch customer data and type
                $customer = $stock->pelanggan;
                $type = $stock->tipe;

                $message = "Serial number exists in the database";
                $exists = true;
            } else {
                $message = 'Serial number does not exist in the database.';
                $exists = false;
            }

            $validationResults[] = [
                'serialNumber' => $serialNumber,
                'exists' => $exists,
                'message' => $message,
                'pelanggan' => $customer ?? null,
                'tipe' => $type ?? null
            ];
        }

        // Return validation results as JSON response
        return response()->json(['validationResults' => $validationResults]);
    }

    public function updateData(Request $request)
    {
        foreach ($request->serialnumbers as $serialnumber) {
            Stock::where('serialnumber', $serialnumber)
                     ->update([
                         'status' => $request->status,
                         'tanggalkeluar' => $request->tanggalkeluar,
                         'pelanggan' => $request->pelanggan
                     ]);
        }

        return response()->json(['message' => 'Data updated successfully']);
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
        $timestamp = now()->format('d-m-Y');
        $fileName = 'DataStock_' . $timestamp . '.xlsx';

        return Excel::download(new StockExport, $fileName);
    }

    public function importStocks(Request $request)
    {
        $rules = [
            'inputStocks' => 'required|mimes:xls,xlsx',
        ];

        $request->validate($rules);

        $data = Excel::toArray(new StockImport, $request->file('inputStocks'));
        $stocksData = collect(head($data))->map(function ($row) {
            $tanggalmasuk = Carbon::createFromDate('1899-12-30')->addDays($row['tanggalmasuk'])->toDateString();
            if ($row['tanggalkeluar'] !== null) {
                $tanggalkeluar = Carbon::createFromDate('1899-12-30')->addDays($row['tanggalkeluar'])->toDateString();
            } else {
                $tanggalkeluar = null;
            }
            return [
                'serialnumber' => $row['serialnumber'],
                'tipe' => $row['tipe'],
                'noinvoice' => $row['noinvoice'],
                'tanggalmasuk' => $tanggalmasuk,
                'tanggalkeluar' => $tanggalkeluar,
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
        $filePath = storage_path('app/template/' . $filename);

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
