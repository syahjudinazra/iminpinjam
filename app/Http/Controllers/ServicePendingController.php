<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicePending;
use Illuminate\Support\Facades\DB;

class ServicePendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicepending = ServicePending::all();
        return view('servicepending.index')->with('servicepending', $servicepending);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicepending.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servicepending = new ServicePending();
        $servicepending->tanggal = $request->input('tanggal');
        $servicepending->serialnumber = $request->input('serialnumber');
        $servicepending->pelanggan = $request->input('pelanggan');
        $servicepending->model = $request->input('model');
        $servicepending->ram = $request->input('ram');
        $servicepending->android = $request->input('android');
        $servicepending->garansi = $request->input('garansi');
        $servicepending->kerusakan = $request->input('kerusakan');
        $servicepending->teknisi = $request->input('teknisi');
        $servicepending->perbaikan = $request->input('perbaikan');
        $servicepending->snkanibal = $request->input('snkanibal');
        $servicepending->nosparepart = $request->input('nosparepart');
        $servicepending->note = $request->input('note');

        $servicepending->save();
        return redirect()->back()->with('success', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function show(ServicePending $servicePending, $id)
    {
        // Find the data by id
        $servicepending = ServicePending::findOrFail($id);

        // // Return the view with the data
        return view('servicepending.index', compact('servicepending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicePending $servicePending, $id)
    {
        $servicepending = ServicePending::findOrFail($id);
        return view('servicepending.index', compact('servicepending'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicePending $servicePending, $id)
    {
        $servicepending = ServicePending::find($id);
        $servicepending->tanggal = $request->input('tanggal');
        $servicepending->serialnumber = $request->input('serialnumber');
        $servicepending->pelanggan = $request->input('pelanggan');
        $servicepending->model = $request->input('model');
        $servicepending->ram = $request->input('ram');
        $servicepending->android = $request->input('android');
        $servicepending->garansi = $request->input('garansi');
        $servicepending->kerusakan = $request->input('kerusakan');
        $servicepending->teknisi = $request->input('teknisi');
        $servicepending->perbaikan = $request->input('perbaikan');
        $servicepending->snkanibal = $request->input('snkanibal');
        $servicepending->nosparepart = $request->input('nosparepart');
        $servicepending->note = $request->input('note');

        $servicepending->update();
        return redirect()->back()->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicePending  $servicePending
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicePending $servicePending, $id)
    {
        // Find the data by id
        $servicePending = ServicePending::findOrFail($id);

        // Delete the servicePending
        $servicePending->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data telah dihapus');
    }

    //move data table
    public function finish(Request $request, ServicePending $servicepending)
    {
        // $servicepending = DB::table('service_pendings')->where('id', '' . $servicepending->id . '')->first();

        // DB::table('service_dones')->insert(
        //     array(
        //         'tanggal'     =>   $servicepending->tanggal,
        //         'serialnumber'   =>   $servicepending->serialnumber,
        //         'pelanggan'   =>   $servicepending->pelanggan,
        //         'model'   =>   $servicepending->model,
        //         'ram'   =>   $servicepending->ram,
        //         'android'   =>   $servicepending->android,
        //         'garansi'   =>   $servicepending->garansi,
        //         'kerusakan'   =>   $servicepending->kerusakan,
        //         'teknisi'   =>   $servicepending->teknisi,
        //         'perbaikan'   =>   $servicepending->perbaikan,
        //         'snkanibal'   =>   $servicepending->snkanibal,
        //         'nosparepart'   =>   $servicepending->nosparepart,
        //         'note'   =>   $servicepending->note,
        //     )
        // );
        // DB::table('service_pendings')->where('id', $servicepending->id)->delete();
        // return redirect('/servicedone')->with('success', 'Data telah dipindahkan');

        $servicepending = DB::table('service_pendings')->get();

        foreach ($servicepending as $data) {
            DB::table('service_dones')->insert([
                'tanggal' => $data->tanggal,
                'serialnumber' => $data->serialnumber,
                'pelanggan' => $data->pelanggan,
                'model' => $data->model,
                'ram' => $data->ram,
                'android' => $data->android,
                'garansi' => $data->garansi,
                'kerusakan' => $data->kerusakan,
                'teknisi' => $data->teknisi,
                'perbaikan' => $data->perbaikan,
                'snkanibal' => $data->snkanibal,
                'nosparepart' => $data->nosparepart,
                'note' => $data->note,
                // dst.
            ]);
        }

        return "Data berhasil dikirim ke tabel tujuan";
    }
}
