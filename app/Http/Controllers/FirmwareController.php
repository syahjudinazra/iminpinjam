<?php

namespace App\Http\Controllers;

use App\Models\Firmware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FirmwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    $desktopFirmware = Firmware::where('kategori', 'desktop')->orderBy('tipe')->get();

    $mobileFirmware = Firmware::where('kategori', 'mobile')->orderBy('tipe')->get();

    $kioskFirmware = Firmware::where('kategori', 'kiosk')->orderBy('tipe')->get();

    return view('firmware.index', compact('desktopFirmware', 'mobileFirmware', 'kioskFirmware'));
    }

    public function table()
    {
        $firmware = Firmware::all();
        return view('firmware.table', compact('firmware'));
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
            'flash' => 'max:255',
            'ota' => 'max:255',
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
        $firmware->flash = $request->input('flash');
        $firmware->ota = $request->input('ota');

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
            'flash' => 'max:255',
            'ota' => 'max:255',
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
        $firmware->flash = $request->input('flash');
        $firmware->ota = $request->input('ota');
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
