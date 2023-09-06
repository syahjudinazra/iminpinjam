<?php

namespace App\Http\Controllers;

use App\Imports\SparePartsImport;
use App\Exports\SparePartsExport;
use App\Models\SpareParts;
use Illuminate\Http\Request;
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

    public function importSpareParts()
    {
        Excel::import(new SparePartsImport, request()->file('file'));

        return back();
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
        } elseif ($request->has('reduce')) {
            if ($spareParts->quantity >= $quantity) {
                $spareParts->quantity -= $quantity;
            } else {
                return redirect()->back()->with('error', 'Jangan Melebihi Quantity');
            }
        }

        $spareParts->save();

        return redirect()->route('spareparts.index', ['id' => $spareParts->id]);
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
            'quantity' => 'required',
        ]);

        $spareParts = new spareParts();
        $spareParts->nospareparts = $request->input('nospareparts');
        $spareParts->tipe = $request->input('tipe');
        $spareParts->nama = $request->input('nama');
        $spareParts->quantity = $request->input('quantity');

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
            'quantity' => 'required',
        ]);

        $spareParts = SpareParts::find($id);
        $spareParts->nospareparts = $request->input('nospareparts');
        $spareParts->tipe = $request->input('tipe');
        $spareParts->nama = $request->input('nama');
        $spareParts->quantity = $request->input('quantity');

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
