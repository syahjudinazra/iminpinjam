<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pinjam = Pinjam::all();
        return view('pinjam.index')->with('pinjam', $pinjam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pinjam.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'serialnumber' => 'required|max:255',
            'device' => 'required|max:255',
            'customer' => 'required|max:255',
            'telp' => 'required|max:255',
            'pengirim' => 'required|max:255',
            'kelengkapankirim' => 'required|max:255',
        ]);

        $validatedData = $request->all();
        $fileName = time().$request->file('gambar')->getClientOriginalName();
        $path = $request->file('gambar')->storeAs('images', $fileName, 'public');
        $validatedData["gambar"] = '/storage/'.$path;

        Pinjam::create($validatedData);

        return redirect('pinjam')->with('success', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function show(Pinjam $pinjam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function edit(Pinjam $pinjam)
    {
        return view('pinjam.index', [
            'pinjam' => $pinjam

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pinjam $pinjam)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|max:255',
            'serialnumber' => 'required|max:255',
            'device' => 'required|max:255',
            'customer' => 'required|max:255',
            'telp' => 'required|max:255',
            'pengirim' => 'required|max:255',
            'kelengkapankirim' => 'required|max:255',
        ]);

        Pinjam::where('id', $pinjam->id)
                  ->update($validatedData);

        return redirect('/pinjam')->with('success', 'Data telah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinjam $pinjam)
    {
        //
    }
}
