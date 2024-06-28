<?php

namespace App\Http\Controllers;

use App\Imports\FirmwareImport;
use App\Models\Firmware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FirmwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('firmware.index');
    }

    public function table()
    {
        $firmware = Firmware::all();
        return view('firmware.table', compact('firmware'));
    }

    public function import(Request $request)
    {
        $rules = [
            'inputFirmware' => 'required|mimes:xls,xlsx',
        ];

        $request->validate($rules);

        $data = Excel::toArray(new FirmwareImport, $request->file('inputFirmware'));

        $firmwareData = collect(head($data))->map(function ($row) {
            return [
                'tipe'     => $row[0],
                'version'  => $row[1],
                'android'  => $row[2],
                'flash'    => $row[3] !== null ? $row[3] : '',
                'ota'      => $row[4] !== null ? $row[4] : '',
                'kategori' => $row[5],
                'gambar'   => $row[6],
            ];
        });

        // Insert the firmware data into the database
        Firmware::insert($firmwareData->toArray());

        return redirect()->back()->with('success', 'Data Berhasil Diimport');
    }


    public function templateImportFirmware($filename)
    {
        $filePath = storage_path('app/template/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function m202()
    {
        $m202 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%m2-202%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.m202Table', compact('m202'));
    }

    public function m203()
    {
        $m203 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%m2-203%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.m203Table', compact('m203'));
    }

    public function m2pro()
    {
        $m2pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%m2 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.m2proTable', compact('m2pro'));
    }

    public function m2max()
    {
        $m2max = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%m2 max%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.m2maxTable', compact('m2max'));
    }

    public function swift1()
    {
        $swift1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swift 1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swift1Table', compact('swift1'));
    }

    public function swift1pro()
    {
        $swift1pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swift 1 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swift1proTable', compact('swift1pro'));
    }

    public function swift2()
    {
        $swift2 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swift 2%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swift2Table', compact('swift2'));
    }

    public function swift2pro()
    {
        $swift2pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swift 2 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swift2proTable', compact('swift2pro'));
    }

    public function d1()
    {
        $d1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d1Table', compact('d1'));
    }

    public function d1pro()
    {
        $d1pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d1 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d1proTable', compact('d1pro'));
    }

    public function falcon1()
    {
        $falcon1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%falcon 1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.falcon1Table', compact('falcon1'));
    }

    public function d2()
    {
        $d2 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d2%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d2Table', compact('d2'));
    }

    public function d3()
    {
        $d3 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d3%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d3Table', compact('d3'));
    }

    public function d4()
    {
        $d4 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d4%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d4Table', compact('d4'));
    }

    public function d4pro()
    {
        $d4pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%d4 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.d4proTable', compact('d4pro'));
    }

    public function swan1()
    {
        $swan1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swan 1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swan1Table', compact('swan1'));
    }

    public function crane1()
    {
        $crane1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%crane 1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.crane1Table', compact('crane1'));
    }

    public function swan1pro()
    {
        $swan1pro = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%swan 1 pro%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.swan1proTable', compact('swan1pro'));
    }

    public function s1()
    {
        $s1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%s1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.s1Table', compact('s1'));
    }

    public function k1()
    {
        $k1 = Firmware::whereRaw('LOWER(tipe) LIKE ?', ['%k1%'])
            ->orderBy('tipe', 'DESC')
            ->get();

        return view('firmware.menuContent.k1Table', compact('k1'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('firmware.table');
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
            'tipe' => 'max:255',
            'version' => 'max:255',
            'android' => 'max:255',
            'flash' => 'max:255|nullable',
            'ota' => 'max:255|nullable',
            'kategori' => 'required|array',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $firmware = new Firmware();
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('storage/gambar/', $filename);
            $firmware->gambar = $filename;
        }

        $firmware->tipe = $request->input('tipe');
        $firmware->version = $request->input('version');
        $firmware->android = $request->input('android');
        $firmware->flash = $request->input('flash') ?? '';
        $firmware->ota = $request->input('ota') ?? '';

        $kategoriValues = $request->input('kategori');
        $kategoriString = implode(',', $kategoriValues);
        $firmware->kategori = $kategoriString;

        $firmware->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $firmware = Firmware::findOrFail($id);
        return view('firmware.table', compact('firmware'));
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
            'tipe' => 'max:255',
            'version' => 'max:255',
            'android' => 'max:255',
            'flash' => 'max:255|nullable',
            'ota' => 'max:255|nullable',
            'kategori' => 'required|max:255',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $firmware = Firmware::find($id);
        if ($request->hasFile('gambar')) {
            $destination = 'storage/gambar/' . $firmware->gambar;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('storage/gambar/', $filename);
            $firmware->gambar = $filename;
        }
        $firmware->tipe = $request->input('tipe');
        $firmware->version = $request->input('version');
        $firmware->android = $request->input('android');
        $firmware->flash = $request->input('flash') ?? '';
        $firmware->ota = $request->input('ota') ?? '';
        $firmware->kategori = $request->input('kategori');

        $firmware->update();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $firmware = Firmware::findOrFail($id);
        $firmware->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
