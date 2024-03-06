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

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($antrianPelanggan)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

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
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#moveModal' . $service->id . '"><i
                                                        class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
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

        $antrianPelanggan = Service::where('status', 'antrian')
                                    ->where('pemilik', 'customer')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.antrianPelanggan', compact('antrianPelanggan', 'serviceDevice'));
    }

    public function validasiPelanggan(Request $request)
    {
        if ($request->ajax()) {
            $validasiPelanggan = Service::where('status', 'validasi')
                                        ->where('pemilik', 'customer')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($validasiPelanggan)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            $allowedRoles = ['superadmin', 'jeffri', 'maulana'];

                            if ($user->hasAnyRole($allowedRoles)) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasAnyRole(['superadmin', 'maulana'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $service->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasAnyRole(['superadmin', 'jeffri'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#moveModal' . $service->id . '"><i
                                                        class="fa-solid fa-paper-plane"></i> Move</a>';
                                }

                                if ($user->hasAnyRole($allowedRoles)) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>';

                                }

                                if ($user->hasAnyRole(['superadmin', 'jeffri'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
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

        $validasiPelanggan = Service::where('status', 'validasi')
                                    ->where('pemilik', 'customer')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.validasiPelanggan', compact('validasiPelanggan', 'serviceDevice'));
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
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

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
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
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

        return view('service.selesaiPelanggan', compact('selesaiPelanggan', 'serviceDevice'));
    }

    //Stock
    public function antrianStock(Request $request)
    {
        if ($request->ajax()) {
            $antrianStock = Service::where('status', 'antrian')
                                        ->where('pemilik', 'stock')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($antrianStock)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

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
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#moveModal' . $service->id . '"><i
                                                        class="fa-solid fa-paper-plane"></i> Move</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
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

        $antrianStock = Service::where('status', 'antrian')
                                    ->where('pemilik', 'stock')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.antrianStock', compact('antrianStock', 'serviceDevice'));
    }
    public function validasiStock(Request $request)
    {
        if ($request->ajax()) {
            $validasiStock = Service::where('status', 'validasi')
                                        ->where('pemilik', 'stock')
                                        ->orderByDesc('tanggalmasuk')
                                        ->get();

            $serviceDevice = DB::table('services_device')->select('name')->get();

            return Datatables::of($validasiStock)
                    ->addIndexColumn()
                    ->addColumn('action', function ($service) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

                        if (auth()->check()) {
                            $user = auth()->user();

                            $allowedRoles = ['superadmin', 'jeffri', 'maulana'];

                            if ($user->hasAnyRole($allowedRoles)) {
                                $actionHtml .= '
                                <div class="dropdown dropright">
                                    <a href="#" class="text-decoration-none dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        More
                                    </a>
                                    <div class="dropdown-menu">';

                                if ($user->hasAnyRole(['superadmin', 'maulana'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#copyText' . $service->id . '"><i
                                                        class="fa-solid fa-clone"></i> Copy</a>';
                                }
                                if ($user->hasAnyRole(['superadmin', 'jeffri'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#moveModal' . $service->id . '"><i
                                                        class="fa-solid fa-paper-plane"></i> Move</a>';
                                }

                                if ($user->hasAnyRole($allowedRoles)) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>';

                                }

                                if ($user->hasAnyRole(['superadmin', 'jeffri'])) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
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

        $validasiStock = Service::where('status', 'validasi')
                                    ->where('pemilik', 'stock')
                                    ->orderByDesc('tanggalmasuk')
                                    ->get();

        $serviceDevice = DB::table('services_device')->select('name')->get();

        return view('service.validasiStock', compact('validasiStock', 'serviceDevice'));
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
                        $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

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
                                if ($user->hasRole('superadmin') || $user->hasRole('jeffri')) {
                                    $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-target="#editModal' . $service->id . '"><i
                                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
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

        return view('service.selesaiStock', compact('selesaiStock', 'serviceDevice'));
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
