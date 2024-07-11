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
use Illuminate\Http\RedirectResponse;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusValues = ['Gudang', 'Service', 'Dipinjam', 'Terjual', 'Rusak', 'Titip'];

        $stockCounts = Stock::whereIn('status', $statusValues)
            ->groupBy('status', 'tipe')
            ->selectRaw('status, tipe, COUNT(*) as count')
            ->get();

        $countByStatus = [];

        foreach ($stockCounts as $count) {
            $countByStatus[$count->status][$count->tipe] = $count->count;
        }

        $stock = Stock::all();
        $stockDevices = DB::table('stocks_device')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.monitor', compact('stock', 'countByStatus', 'stockDevices', 'stockSku'));
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
                $stats = $stock->status;

                $message = "Exist";
                $exists = true;
            } else {
                $message = 'Not Exist';
                $exists = false;
            }

            $validationResults[] = [
                'serialNumber' => $serialNumber,
                'exists' => $exists,
                'message' => $message,
                'pelanggan' => $customer ?? null,
                'tipe' => $type ?? null,
                'status' => $stats ?? null,
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
                    'pelanggan' => $request->pelanggan,
                    'lokasi' => $request->lokasi,
                    'keterangan' => $request->keterangan,
                ]);
        }

        return response()->json(['message' => 'Move SN Berhasil']);
    }

    public function allstocks(Request $request)
    {
        if ($request->ajax()) {
            $allstocks = Stock::orderBy('created_at', 'desc');

            return DataTables::of($allstocks)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showAllStocks', ['id' => $row->id]) . '"
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editAllStocks', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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
        $allstocks = Stock::orderBy('created_at', 'desc');

        return view('stock.allstocks.index', compact('allstocks'));
    }

    public function gudang(Request $request)
    {
        if ($request->ajax()) {
            $stockGudang = Stock::where('status', 'gudang')->orderBy('created_at', 'desc');

            return DataTables::of($stockGudang)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showGudang', ['id' => $row->id]) . '" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                    if (auth()->check()) {
                        $user = auth()->user();

                        // Check for roles that can perform edit and delete actions
                        if ($user->hasAnyRole(['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi'])) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                            $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editGudang', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                            ' . csrf_field() . '
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                            </form>';

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
        $stockGudang = Stock::where('status', 'gudang')->orderBy('created_at', 'desc')->paginate(10);

        return view('stock.digudang.index', compact('stockGudang'));
    }

    public function service(Request $request)
    {
        if ($request->ajax()) {
            $stockService = Stock::where('status', 'service')->orderBy('created_at', 'desc');

            return DataTables::of($stockService)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showDiservice', ['id' => $row->id]) . '"
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editDiservice', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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

        $stockService = Stock::where('status', 'service')->orderBy('created_at', 'desc');

        return view('stock.diservice.index', compact('stockService'));
    }

    public function dipinjam(Request $request)
    {
        if ($request->ajax()) {
            $stockDipinjam = Stock::where('status', 'dipinjam')->orderBy('created_at', 'desc');

            return DataTables::of($stockDipinjam)
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editPinjam', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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

        $stockDipinjam = Stock::where('status', 'dipinjam')->orderBy('created_at', 'desc');

        return view('stock.dipinjam.index', compact('stockDipinjam'));
    }

    public function terjual(Request $request)
    {
        if ($request->ajax()) {
            $stockTerjual = Stock::where('status', 'terjual')->orderBy('created_at', 'desc');

            return DataTables::of($stockTerjual)
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editTerjual', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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

        return view('stock.terjual.index', compact('stockTerjual'));
    }

    public function rusak(Request $request)
    {
        if ($request->ajax()) {
            $stockRusak = Stock::where('status', 'rusak')->orderBy('created_at', 'desc');

            return DataTables::of($stockRusak)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showRusak', ['id' => $row->id]) . '"
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editRusak', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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

        $stockRusak = Stock::where('status', 'rusak')->orderBy('created_at', 'desc');
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.rusak.index', compact('stockRusak'));
    }

    public function titip(Request $request)
    {
        if ($request->ajax()) {
            $stockTitip = Stock::where('status', 'titip')->orderBy('created_at', 'desc');

            return DataTables::of($stockTitip)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="' . route('stock.showTitip', ['id' => $row->id]) . '"
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
                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editTitip', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
                                    '<form action="' . route('stock.destroy', ['id' => $row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin mau hapus data ini?\');">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>';
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

        $stockTitip = Stock::where('status', 'rusak')->orderBy('created_at', 'desc');
        $stockDevice = DB::table('stocks_device')->select('name')->get();

        return view('stock.titip.index', compact('stockTitip'));
    }

    public function exportStocks()
    {
        $timestamp = now()->format('d-m-Y');
        $fileName = 'DataStock_' . $timestamp . '.xlsx';

        return Excel::download(new StockExport, $fileName);
    }

    public function importStocks(Request $request)
    {
        ini_set('max_execution_time', 600);

        $rules = [
            'inputStocks' => 'required|mimes:xls,xlsx,csv',
        ];

        $request->validate($rules);

        try {
            $data = Excel::toArray(new StockImport, $request->file('inputStocks'));
            $stocksData = collect(head($data))->map(function ($row) {
                $tanggalmasuk = Carbon::createFromDate('1899-12-30')->addDays($row['tanggalmasuk'])->toDateString();
                $tanggalkeluar = $row['tanggalkeluar'] !== null
                    ? Carbon::createFromDate('1899-12-30')->addDays($row['tanggalkeluar'])->toDateString()
                    : null;

                return [
                    'serialnumber' => $row['serialnumber'],
                    'tipe' => $row['tipe'],
                    'sku' => $row['sku'],
                    'noinvoice' => $row['noinvoice'] ?? '',
                    'tanggalmasuk' => $tanggalmasuk,
                    'tanggalkeluar' => $tanggalkeluar,
                    'pelanggan' => $row['pelanggan'] ?? '',
                    'lokasi' => $row['lokasi'],
                    'keterangan' => $row['keterangan'] ?? '',
                    'status' => $row['status'],
                ];
            })->filter(function ($stock) {
                return $stock['serialnumber'] !== null;
            })->keyBy('serialnumber')->toArray();

            foreach ($stocksData as $serialnumber => $stock) {
                DB::table('stocks')->updateOrInsert(
                    ['serialnumber' => $serialnumber],
                    $stock
                );
            }

            return redirect()->back()->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            // Log error
            return redirect()->back()->with('error', 'Data gagal diimport' . $e->getMessage());
        }
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
            $stock = new Stock();
            $stock->serialnumber = $request->input('serialnumber');
            $stock->tipe = $request->input('tipe');
            $stock->sku = $request->input('sku');
            $stock->noinvoice = $request->input('noinvoice') ?? '';
            $stock->tanggalmasuk = $request->input('tanggalmasuk');
            $stock->tanggalkeluar = $request->input('tanggalkeluar');
            $stock->pelanggan = $request->input('pelanggan');
            $stock->lokasi = $request->input('lokasi');
            $stock->keterangan = $request->input('keterangan') ?? '';
            $statusValues = $request->input('status');
            $statusString = implode(',', $statusValues);
            $stock->status = $statusString;

            $stock->save();

            return redirect()->back()->withToastSuccess('Data berhasil ditambahkan');
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
    public function showAllStocks(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.allstocks.view', compact('stock'));
    }

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

    public function showRusak(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.rusak.view', compact('stock'));
    }

    public function showTitip(Stock $stock, $id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.titip.view', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function editGudang($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.digudang.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editAllStocks($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.allstocks.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editPinjam($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.dipinjam.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editDiservice($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.diservice.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editTerjual($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.terjual.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editRusak($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.rusak.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    public function editTitip($id)
    {
        $stock = Stock::findOrFail($id);
        $stockDevice = DB::table('stocks_device')->select('name')->get();
        $stockLokasi = DB::table('stocks_location')->select('name')->get();
        $stockSku = DB::table('stocks_sku')->select('name')->get();

        return view('stock.titip.edit', compact('stock', 'stockDevice', 'stockLokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function updateAllStocks(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/gudang')->with('success', 'Data berhasil diubah');
    }

    public function updateGudang(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/gudang')->with('success', 'Data berhasil diubah');
    }

    public function updateDipinjam(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/dipinjam')->with('success', 'Data berhasil diubah');
    }

    public function updateDiservice(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/service')->with('success', 'Data berhasil diubah');
    }

    public function updateTerjual(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/terjual')->with('success', 'Data berhasil diubah');
    }

    public function updateRusak(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/rusak')->with('success', 'Data berhasil diubah');
    }

    public function updateTitip(Request $request, Stock $stock, $id)
    {
        $request->validate([
            'serialnumber' => 'required|max:255',
            'tipe' => 'required|max:255',
            'sku' => 'required|max:255',
            'noinvoice' => 'max:255|nullable',
            'tanggalmasuk' => 'required|max:255',
            'tanggalkeluar' => 'max:255|nullable',
            'pelanggan' => 'max:255',
            'lokasi' => 'required|max:255',
            'keterangan' => 'max:255|nullable',
            'status' => 'required|max:255',
        ]);

        $stock = Stock::find($id);
        $stock->serialnumber = $request->input('serialnumber');
        $stock->tipe = $request->input('tipe');
        $stock->sku = $request->input('sku');
        $stock->noinvoice = $request->input('noinvoice') ?? '';
        $stock->tanggalmasuk = $request->input('tanggalmasuk');
        $stock->tanggalkeluar = $request->input('tanggalkeluar');
        $stock->pelanggan = $request->input('pelanggan');
        $stock->lokasi = $request->input('lokasi');
        $stock->keterangan = $request->input('keterangan') ?? '';
        $stock->status = $request->input('status');

        $stock->update();
        return redirect('stock/titip')->with('success', 'Data berhasil diubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
