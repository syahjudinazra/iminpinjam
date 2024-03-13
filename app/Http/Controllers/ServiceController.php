<?php

namespace App\Http\Controllers;

use App\DataTables\AntrianPelangganDataTable;
use App\DataTables\ServiceDataTable;
use App\DataTables\ServicePelangganDataTable;
use App\Exports\ServiceAllExport;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Exports\ServiceExport;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.index', compact('serviceDevice'));
    }

    //Pelanggan
    public function antrianPelanggan(Request $request)
    {
        if ($request->ajax()) {
            $antrianPelanggan = Service::where('status', 'antrian')
                                        ->where('pemilik', 'customer')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            return Datatables::of($antrianPelanggan)
                    ->addIndexColumn()
                    ->addColumn('action', function ($antrianPelanggan) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showAntrianPelanggan', ['id' => $antrianPelanggan->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $antrianPelanggan->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="' . route('service.moveAntrianPelanggan', ['id' => $antrianPelanggan->id]) . '
                                    " target="_blank" ><i class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="' . route('service.editAntrianPelanggan', ['id' => $antrianPelanggan->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $antrianPelanggan->id . '"><i
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

        $antrianPelanggan = Service::where('status', 'antrian')
                                    ->where('pemilik', 'customer')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        return view('service.antrianPelanggan.index', compact('antrianPelanggan'));
    }

    public function validasiPelanggan(Request $request)
    {
        if ($request->ajax()) {
            $validasiPelanggan = Service::where('status', 'validasi')
                                        ->where('pemilik', 'customer')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            return Datatables::of($validasiPelanggan)
                    ->addIndexColumn()
                    ->addColumn('action', function ($validasiPelanggan) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showValidasiPelanggan', ['id' => $validasiPelanggan->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $validasiPelanggan->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '  <a class="dropdown-item" href="' . route('service.moveValidasiPelanggan', ['id' => $validasiPelanggan->id]) . '
                                    " target="_blank" ><i class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="' . route('service.editValidasiPelanggan', ['id' => $validasiPelanggan->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $validasiPelanggan->id . '"><i
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

        $validasiPelanggan = Service::where('status', 'validasi')
                                    ->where('pemilik', 'customer')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        return view('service.validasiPelanggan.index', compact('validasiPelanggan'));
    }

    public function selesaiPelanggan(Request $request)
    {
        if ($request->ajax()) {
            $selesaiPelanggan = Service::where('status', 'selesai')
                                        ->where('pemilik', 'customer')
                                        ->orderByDesc('tanggalkeluar')
                                        ->get();

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($selesaiPelanggan)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showSelesaiPelanggan', ['id' => $service->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';
                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $service->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="' . route('service.editSelesaiPelanggan', ['id' => $service->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $service->id . '"><i
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

        $selesaiPelanggan = Service::where('status', 'selesai')
                                    ->where('pemilik', 'customer')
                                    ->orderByDesc('tanggalkeluar')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.selesaiPelanggan.index', compact('selesaiPelanggan', 'serviceDevice'));
    }

    //Stock
    public function antrianStock(Request $request)
    {
        if ($request->ajax()) {
            $antrianStock = Service::where('status', 'antrian')
                                        ->where('pemilik', 'stock')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            return Datatables::of($antrianStock)
                    ->addIndexColumn()
                    ->addColumn('action', function ($antrianStock) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showAntrianStock', ['id' => $antrianStock->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $antrianStock->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '  <a class="dropdown-item" href="' . route('service.moveAntrianStock', ['id' => $antrianStock->id]) . '
                                    " target="_blank" ><i class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="' . route('service.editAntrianStock', ['id' => $antrianStock->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $antrianStock->id . '"><i
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

        $antrianStock = Service::where('status', 'antrian')
                                    ->where('pemilik', 'stock')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        return view('service.antrianStock.index', compact('antrianStock'));
    }
    public function validasiStock(Request $request)
    {
        if ($request->ajax()) {
            $validasiStock = Service::where('status', 'validasi')
                                        ->where('pemilik', 'stock')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            return Datatables::of($validasiStock)
                    ->addIndexColumn()
                    ->addColumn('action', function ($validasiStock) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showValidasiStock', ['id' => $validasiStock->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $validasiStock->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '  <a class="dropdown-item" href="' . route('service.moveValidasiStock', ['id' => $validasiStock->id]) . '
                                    " target="_blank" ><i class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="' . route('service.editValidasiStock', ['id' => $validasiStock->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $validasiStock->id . '"><i
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

        $validasiStock = Service::where('status', 'validasi')
                                    ->where('pemilik', 'stock')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        return view('service.validasiStock.index', compact('validasiStock'));
    }
    public function selesaiStock(Request $request)
    {
        if ($request->ajax()) {
            $selesaiStock = Service::where('status', 'selesai')
                                        ->where('pemilik', 'stock')
                                        ->orderByDesc('tanggalkeluar')
                                        ->get();

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($selesaiStock)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('service.showSelesaiStock', ['id' => $service->id]) . '"
                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';
                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $service->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                                    $actionHtml .= '<a class="dropdown-item" href="' . route('service.editSelesaiStock', ['id' => $service->id]) . '
                                                    " target="_blank" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal' . $service->id . '"><i
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

        $selesaiStock = Service::where('status', 'selesai')
                                    ->where('pemilik', 'stock')
                                    ->orderByDesc('tanggalkeluar')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.selesaiStock.index', compact('selesaiStock', 'serviceDevice'));
    }

    public function exportService(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = Service::whereBetween('tanggalkeluar', [$startDate, $endDate])->get();

        // Generate a datetime stamp
        $timestamp = now()->format('d-m-Y');

        // Construct the file name with the datetime stamp
        $fileName = 'DataService_' . $timestamp . '.xlsx';

        return Excel::download(new ServiceExport($data), $fileName);
    }

    public function exportAll()
    {
        $timestamp = now()->format('d-m-Y');
        $fileName = 'DataAllService' . $timestamp . '.xlsx';

        return Excel::download(new ServiceAllExport, $fileName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.index', compact('serviceDevice'));
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

    public function showAntrianPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.antrianPelanggan.view', compact('service', 'serviceDevice'));
    }

    public function showValidasiPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.validasiPelanggan.view', compact('service', 'serviceDevice'));
    }

    public function showSelesaiPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.selesaiPelanggan.view', compact('service', 'serviceDevice'));
    }

    public function showAntrianStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.antrianStock.view', compact('service', 'serviceDevice'));
    }

    public function showValidasiStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.validasiStock.view', compact('service', 'serviceDevice'));
    }

    public function showSelesaiStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice = DB::table('services_device')->select('name')->get();
        return view('service.selesaiStock.view', compact('service', 'serviceDevice'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editAntrianPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.antrianPelanggan.edit', compact('service', 'serviceDevice'));
    }

    public function editValidasiPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.validasiPelanggan.edit', compact('service', 'serviceDevice'));
    }

    public function editSelesaiPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.selesaiPelanggan.edit', compact('service', 'serviceDevice'));
    }

    public function editAntrianStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.antrianStock.edit', compact('service', 'serviceDevice'));
    }

    public function editValidasiStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.validasiStock.edit', compact('service', 'serviceDevice'));
    }

    public function editSelesaiStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.selesaiStock.edit', compact('service', 'serviceDevice'));
    }

    public function moveAntrianPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.antrianPelanggan.move', compact('service', 'serviceDevice'));
    }

    public function moveValidasiPelanggan($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.validasiPelanggan.move', compact('service', 'serviceDevice'));
    }

    public function moveAntrianStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.antrianStock.move', compact('service', 'serviceDevice'));
    }

    public function moveValidasiStock($id)
    {
        $service = Service::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();
        return view('service.validasiStock.move', compact('service', 'serviceDevice'));
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
                case 'antrian':
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
