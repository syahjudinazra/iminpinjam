<?php

namespace App\Http\Controllers;

use App\Models\SpareParts;
use Illuminate\Http\Request;
use App\Exports\SparePartsExport;
use App\Imports\SparePartsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SparePartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spareParts = SpareParts::all();

        return view('spareparts.index', compact('spareParts'));
    }

    public function importSpareParts(Request $request)
    {
        $rules = [
            'inputSpareParts' => 'required|mimes:xls,xlsx',
        ];

        $request->validate($rules);

        $data = Excel::toArray(new SparePartsImport, $request->file('inputSpareParts'));

        $sparePartsData = collect(head($data))->map(function ($row) {
            return [
                'nospareparts' => $row['nospareparts'],
                'tipe' => $row['tipe'],
                'nama' => $row['nama'],
                'quantity' => $row['quantity'],
                'harga' => $row['harga'],
            ];
        })->filter(function ($sparePart) {
            return $sparePart['nospareparts'] !== null;
        })->keyBy('nospareparts')->toArray();

        foreach ($sparePartsData as $noSparePart => $sparePart) {
            DB::table('spareparts')->updateOrInsert(
                ['nospareparts' => $noSparePart],
                $sparePart
            );
        }

        return redirect()->back()->with('success', 'Data Berhasil Diimport');
    }

    public function exportSpareParts()
    {
        return Excel::download(new SparePartsExport, 'DataSpareParts.xlsx');
    }

    public function updateQuantity(Request $request, $id)
    {
        $spareParts = SpareParts::findOrFail($id);
        $quantity = $request->input('quantity');

        if ($request->has('add')) {
            $spareParts->quantity += $quantity;

            $spareParts->save();
            return redirect()->back()->with('success', 'Data Berhasil Ditambah');

        } elseif ($request->has('reduce')) {
            if ($spareParts->quantity >= $quantity) {
                $spareParts->quantity -= $quantity;
                $spareParts->save();
                return redirect()->back()->with('success', 'Data Berhasil Dikurangi');
            } else {
                return redirect()->back()->with('error', 'Jangan Melebihi Quantity');
            }
        }
    }

    public function templateImport($filename)
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
        return view('spareparts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSparePartsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nospareparts' => 'max:255',
            'tipe' => 'max:255',
            'nama' => 'max:255',
            'quantity' => 'numeric',
            'harga' => 'numeric',
        ]);

        $spareParts = new spareParts();
        $spareParts->nospareparts = $request->input('nospareparts');
        $spareParts->tipe = $request->input('tipe');
        $spareParts->nama = $request->input('nama');
        $spareParts->quantity = $request->input('quantity');
        $spareParts->harga = $request->input('harga');

        $spareParts->save();
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpareParts  $spareParts
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpareParts  $spareParts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spareParts = SpareParts::findOrFail($id);
        return view('spareparts.index', compact('spareParts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSparePartsRequest  $request
     * @param  \App\Models\SpareParts  $spareParts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nospareparts' => 'max:255',
            'tipe' => 'max:255',
            'nama' => 'max:255',
            'quantity' => 'numeric',
            'harga' => 'numeric',
        ]);

        $spareParts = SpareParts::find($id);
        $spareParts->nospareparts = $request->input('nospareparts');
        $spareParts->tipe = $request->input('tipe');
        $spareParts->nama = $request->input('nama');
        $spareParts->quantity = $request->input('quantity');
        $spareParts->harga = $request->input('harga');

        $spareParts->update();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpareParts  $spareParts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $spareParts = SpareParts::findOrFail($id);
        $spareParts->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
