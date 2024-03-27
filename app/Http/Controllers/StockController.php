<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Exports\StockExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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

    public function gudang(Request $request)
    {
        if ($request->ajax()) {
            $stockGudang = Stock::where('status', 'gudang')->orderBy('created_at', 'desc');

            return DataTables::of($stockGudang)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showGudang', ['id' => $row->id]) . '"
                    class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                    if (auth()->check()) {
                        $user = auth()->user();

                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editGudang', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                               '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-target="#deleteModal' . $row->id . '"><i class="fa-solid fa-trash"></i> Delete</a>';
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

        // If it's not an AJAX request, return the view with paginated data
        $stockGudang = Stock::where('status', 'gudang')->orderBy('created_at', 'desc');
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.digudang.index', compact('stockGudang', 'stockDevice'));
    }

    public function service(Request $request)
    {
        if ($request->ajax()) {
            $stockService = Stock::where('status', 'service')->orderBy('created_at', 'desc')->get();

            return DataTables::of($stockService)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $row->id . '"><i class="fa-solid fa-eye"></i>View</a>';
                    if (auth()->check()) {
                        $user = auth()->user();

                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editDiservice', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                               '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-target="#deleteModal' . $row->id . '"><i class="fa-solid fa-trash"></i> Delete</a>';
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

        // If it's not an AJAX request, return the view with paginated data
        $stockService = Stock::where('status', 'service')->orderBy('created_at', 'desc')->get();
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.diservice.index', compact('stockService', 'stockDevice'));
    }

    public function dipinjam(Request $request)
    {
        if ($request->ajax()) {
            $stockDipinjam = Stock::where('status', 'dipinjam')->orderBy('created_at', 'desc');

            return DataTables::of($stockDipinjam)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showPinjam', ['id' => $row->id]) . '"
                    class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';
                    if (auth()->check()) {
                        $user = auth()->user();

                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editPinjam', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                               '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-target="#deleteModal' . $row->id . '"><i class="fa-solid fa-trash"></i> Delete</a>';
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

        // If it's not an AJAX request, return the view with paginated data
        $stockDipinjam = Stock::where('status', 'dipinjam')->orderBy('created_at', 'desc');
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.dipinjam.index', compact('stockDipinjam', 'stockDevice'));
    }

    public function terjual(Request $request)
    {
        if ($request->ajax()) {
            $stockTerjual = Stock::where('status', 'terjual')->orderBy('created_at', 'desc');

            return DataTables::of($stockTerjual)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showTerjual', ['id' => $row->id]) . '"
                    class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';
                    if (auth()->check()) {
                        $user = auth()->user();

                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('sylvi') || $user->hasRole('coni') || $user->hasRole('vivi')) {
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editTerjual', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>'.
                                '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#deleteModal' . $row->id . '"><i
                                class="fa-solid fa-trash"></i> Delete</a>';
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

        $stockTerjual = Stock::where('status', 'terjual')->orderBy('created_at', 'desc');
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.terjual.index', compact('stockTerjual', 'stockDevice'));
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
                'keterangan' => $row['keterangan'],
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
            'serialnumber' => 'required|regex:/^\S*$/|max:255',
            'tipe' => 'required|max:255',
            'noinvoice' => 'required|max:255',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255',
            'pelanggan' => 'max:255',
            'keterangan' => 'max:255',
            'status' => 'required|array',
        ]);

        try {
            $stock = new Stock();
            $stock->serialnumber = $request->input('serialnumber');
            $stock->tipe = $request->input('tipe');
            $stock->noinvoice = $request->input('noinvoice');
            $stock->tanggalmasuk = $request->input('tanggalmasuk');
            $stock->tanggalkeluar = $request->input('tanggalkeluar');
            $stock->pelanggan = $request->input('pelanggan');
            $stock->keterangan = $request->input('keterangan');
            $statusValues = $request->input('status');
            $statusString = implode(',', $statusValues);
            $stock->status = $statusString;

            $stock->save();

            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function showGudang(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.digudang.view', compact('stock'));
    }

    public function showPinjam(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.dipinjam.view', compact('stock'));
    }

    public function showDiservice(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.diservice.view', compact('stock'));
    }

    public function showTerjual(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.terjual.view', compact('stock'));
    }

    // public function show($id)
    // {
    //     $stock = Stock::findOrFail($id);
    //     return view('stock.terjual.index', compact('stock'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function editGudang(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.digudang.edit', compact('stock', 'stockDevice'));
    }

    public function editPinjam(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice =DB::table('stocks_device')->select('name')->get();

        return view('stock.dipinjam.edit', compact('stock', 'stockDevice'));
    }

    public function editDiservice(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice =DB::table('stocks_device')->select('name')->get();

        return view('stock.diservice.edit', compact('stock', 'stockDevice'));
    }

    public function editTerjual(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice =DB::table('stocks_device')->select('name')->get();

        return view('stock.terjual.edit', compact('stock', 'stockDevice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function updateGudang(Request $request, Stock $stock, $id)
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
            return redirect('stock/gudang')->with('success', 'Data berhasil diubah');
    }

    public function updateDipinjam(Request $request, Stock $stock, $id)
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
            return redirect('stock/dipinjam')->with('success', 'Data berhasil diubah');
    }

    public function updateDiservice(Request $request, Stock $stock, $id)
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
            return redirect('stock/service')->with('success', 'Data berhasil diubah');
    }

    public function updateTerjual(Request $request, Stock $stock, $id)
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
            return redirect('stock/terjual')->with('success', 'Data berhasil diubah');
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
