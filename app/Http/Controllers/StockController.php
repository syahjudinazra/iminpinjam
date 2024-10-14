<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Pengiriman;
use App\Exports\StockExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;

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

    public function moveSN(Request $request)
    {
        try {
            if (!$request->has('serialnumbers')) {
                return redirect()->back()->with(['error' => 'No serial numbers provided']);
            }

            $serialNumbers = json_decode($request->serialnumbers, true);
            foreach ($serialNumbers as $serialnumber) {
                $stock = Stock::where('serialnumber', $serialnumber)->first();
                if ($stock) {
                    $stock->update([
                        'status' => $request->status,
                        'tanggalkeluar' => $request->tanggalkeluar,
                        'pelanggan' => $request->pelanggan,
                        'lokasi' => $request->lokasi,
                        'keterangan' => $request->keterangan,
                        'kode_pengiriman' => $request->kode_pengiriman,
                    ]);
                }
            }

            return response()->json(['success' => 'Move SN Berhasil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Move SN Gagal: ' . $e->getMessage()]);
        }
    }


    public function history(Request $request)
    {
        if ($request->ajax()) {
            $modelType = $request->get('model_type', Stock::class);

            $stockHistory = $modelType::with(['activity.causer', 'activity.subject'])
                                    ->whereHas('activity', function ($query) use ($modelType) {
                                        $query->where('subject_type', $modelType);
                                    })
                                    ->latest()
                                    ->get(); // Make sure to get the collection

            $data = $stockHistory->flatMap(function($stock) {
                return $stock->activity->map(function($activity) use ($stock) {
                    return [
                        'causer.name' => optional($activity->causer)->name,
                        'subject.serialnumber' => optional($activity->subject)->serialnumber,
                        'subject.tipe' => optional($activity->subject)->tipe,
                        'properties.old' => $this->formatProperties(optional($activity->properties)['old']),
                        'properties.attributes' => $this->formatProperties(optional($activity->properties)['attributes']),
                        'description' => $activity->description,
                        'created_at' => Carbon::parse($activity->created_at)->timezone('Asia/Jakarta')->format('d-m-Y h:i:s'),
                    ];
                });
            });

            return DataTables::of($data)->make(true);
        }

        return view('stock.history.index');
    }

    private function formatProperties($property)
    {
        if (is_array($property)) {
            return str_replace(['{', '}', '"'], ' ', json_encode($property));
        }
        return $property;
    }

    public function pengirimanPelanggan(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'GDG%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i></a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.pelanggan.index', compact('pengirimans'));
    }

    public function pengirimanService(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'RSV%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i> Cek SN</a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.service.index', compact('pengirimans'));
    }

    public function pengirimanDipinjam(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'LOA%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i> Cek SN</a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.dipinjam.index', compact('pengirimans'));
    }

    public function pengirimanTerjual(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'DO%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i> Cek SN</a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.terjual.index', compact('pengirimans'));
    }

    public function pengirimanTitip(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'TIP%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i> Cek SN</a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.titip.index', compact('pengirimans'));
    }

    public function pengirimanRusak(Request $request)
    {
        if (!Schema::hasColumn('stocks', 'kode_pengiriman')) {
            return response()->json(['error' => 'Column does not exist'], 404);
        }

        $pengirimans = Stock::whereNotNull('kode_pengiriman')
            ->where('kode_pengiriman', 'LIKE', 'EOL%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kode_pengiriman')
            ->map(function ($group) {
                return [
                    'kode_pengiriman' => $group->first()->kode_pengiriman,
                    'serialnumber' => $group->pluck('serialnumber')->all(),
                    'tipe' => $group->first()->tipe,
                    'pelanggan' => $group->first()->pelanggan,
                    'serial_count' => $group->count(),
                    'id' => md5($group->first()->kode_pengiriman)
                ];
            });

        if ($request->ajax()) {
            return DataTables::of($pengirimans)
                ->addColumn('action', function ($row) {
                    $actionHtml = '<div class="d-flex align-items-center gap-3">';
                    $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#cekSN' . $row['id'] . '"><i class="fa-solid fa-eye"></i> Cek SN</a>';
                    $actionHtml .= '</div>';
                    $actionHtml .= $this->cekSnModal($row);
                    return $actionHtml;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock.pengiriman.rusak.index', compact('pengirimans'));
    }

    private function cekSnModal($row)
    {
        return '
            <div class="modal fade" id="cekSN' . $row['id'] . '" tabindex="-1" aria-labelledby="cekSNLabel' . $row['id'] . '" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cekSNLabel' . $row['id'] . '">Validasi Serial Number</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="validateForm' . $row['id'] . '" method="POST" action="' . route('validate.serialnumber') . '">
                                ' . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <div class="form-group">
                                    <label for="cekOldSN">Serial Numbers</label>
                                    <textarea id="cekOldSN" class="form-control shadow-none bg-light" name="cekOldSN" rows="4" readonly oncopy="return false;">' . implode("\n", $row['serialnumber']) . '</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cekInputSN">Input Serial Numbers</label>
                                    <textarea id="cekInputSN" class="form-control shadow-none" name="cekInputSN" rows="4"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="document.getElementById(\'validateForm' . $row['id'] . '\').submit();">Validasi</button>
                        </div>
                    </div>
                </div>
            </div>';
    }


    public function validateSerialNumber(Request $request)
    {
        $request->validate([
            'cekOldSN' => 'required',
            'cekInputSN' => 'required',
        ]);

        $oldSN = explode("\n", trim($request->input('cekOldSN')));
        $inputSN = explode("\n", trim($request->input('cekInputSN')));

        $oldSN = array_map('trim', $oldSN);
        $inputSN = array_map('trim', $inputSN);

        if ($oldSN == $inputSN) {
            $record = Stock::where('serialnumber', $oldSN[0])->first();
            if ($record) {
                Stock::where('kode_pengiriman', $record->kode_pengiriman)->update(['kode_pengiriman' => null]);
            }
            return redirect()->back()->with('success', 'Validasi Berhasil');
        } else {
            return redirect()->back()->with('error', 'Validasi Gagal! SN yang dimasukan tidak sesuai');
        }
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editAllStocks', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        // Check for roles that can perform edit and delete actions
                        if ($user->hasAnyRole($roles)) {
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editDiservice', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editPinjam', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editTerjual', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editRusak', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
                        $roles = ['superadmin', 'jeffri', 'sylvi', 'coni', 'vivi', 'anggi'];

                        if ($user->hasAnyRole($roles)) {
                            $actionHtml .= '<div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">';

                                $actionHtml .= '<a class="dropdown-item" href="' . route('stock.editTitip', ['id' => $row->id]) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>' .
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
            'kode_pengiriman' => 'max:255|nullable',
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
            $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
            'kode_pengiriman' => 'max:255|nullable',
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
        $stock->kode_pengiriman = $request->input('kode_pengiriman') ?? '';
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
