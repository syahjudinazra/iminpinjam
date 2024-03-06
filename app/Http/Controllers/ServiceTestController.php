<?php

namespace App\Http\Controllers;

use App\Models\ServiceTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $serviceTest = ServiceTest::all();

            return Datatables::of($serviceTest)
                    ->addIndexColumn()
                    ->addColumn('action', function ($serviceTest) {
                        $actionHtml = '<div class="d-flex align-items-center gap-3">';
                        $actionHtml .= '<a href="' . route('servicetest.show', ['id' => $serviceTest->id]) . '"
                                        target="_blank" class="text-decoration-none"><i class="fa-solid fa-eye"></i> View</a>';

                        $actionHtml .= '<div class="dropdown dropright">
                                            <a href="#" class="text-decoration-none dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false">
                                                More
                                            </a>
                                            <div class="dropdown-menu">';
                        $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-target="#copyText' . $serviceTest->id . '"><i
                                            class="fa-solid fa-clone"></i> Copy</a>';
                        // $actionHtml .= '<a class="dropdown-item" href="' . route('servicetest.move', ['id' => $serviceTest->id]) . '">
                        //                     <i class="fa-solid fa-pen-to-square"></i> Move</a>';
                        $actionHtml .= '<a class="dropdown-item" href="' . route('servicetest.edit', ['id' => $serviceTest->id]) . '" target="_blank" >
                                            <i class="fa-solid fa-pen-to-square"></i> Edit</a>';
                        $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-target="#deleteModal' . $serviceTest->id . '"><i
                                                class="fa-solid fa-trash"></i> Delete</a>';

                        $actionHtml .= '</div>
                                    </div>';

                        $actionHtml .= '</div>';
                        return $actionHtml;
                    })

                    ->rawColumns(['action'])
                    ->make(true);
        }

        $serviceTest = ServiceTest::all();

        return view('serviceTest.index', compact('serviceTest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('serviceTest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

            $serviceTest = new ServiceTest();
            $serviceTest->serialnumber = $request->input('serialnumber');
            $serviceTest->tanggalmasuk = $request->input('tanggalmasuk');
            $serviceTest->tanggalkeluar = $request->input('tanggalkeluar');
            $serviceTest->pemilik = $request->input('pemilik');
            $serviceTest->status = $request->input('status');
            $serviceTest->pelanggan = $request->input('pelanggan');
            $serviceTest->device = $request->input('device');
            $serviceTest->pemakaian = $request->input('pemakaian');
            $serviceTest->kerusakan = $request->input('kerusakan');
            $serviceTest->perbaikan = $request->input('perbaikan');
            $serviceTest->nosparepart = $request->input('nosparepart');
            $serviceTest->snkanibal = $request->input('snkanibal');
            $serviceTest->teknisi = $request->input('teknisi');
            $serviceTest->catatan = $request->input('catatan');

            $pemilikValues = $request->input('pemilik');
            $pemilikString = implode(',', $pemilikValues);
            $serviceTest->pemilik = $pemilikString;

            $statusValues = $request->input('status');
            $statusString = implode(',', $statusValues);
            $serviceTest->status = $statusString;

            $serviceTest->save();
            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceTest = ServiceTest::findOrFail($id);
        return view('serviceTest.view', compact('serviceTest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $serviceTest = ServiceTest::findOrFail($id);
        $serviceDevice =DB::table('services_device')->select('name')->get();

        return view('serviceTest.edit', compact('serviceTest', 'serviceDevice'));
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

        $serviceTest = ServiceTest::find($id);

        // Store the original 'status' value
        $originalStatus = $serviceTest->status;

        // Update the service with the new values
        $serviceTest->fill($request->all())->save();

        // Check if 'status' field is changed
        if ($originalStatus !== $serviceTest->status) {
            $statusMessage = '';

            // Check the updated 'status' value and set the appropriate message
            switch ($serviceTest->status) {
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
        $serviceTest = ServiceTest::findOrFail($id);
        $serviceTest->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
