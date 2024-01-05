<?php

namespace App\Http\Controllers;

use App\Models\Kanibal;
use App\Models\Pinjam;
use App\Models\ServiceDone;
use Illuminate\Http\Request;
use App\Models\ServicePending;
use App\Models\SpareParts;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'servicedone' => DB::table('service_dones')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'servicedone'),
            'servicepending' => DB::table('service_pendings')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'servicepending'),
            'kanibal' => DB::table('kanibals')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'kanibal'),
            'pinjam' => DB::table('pinjams')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'pinjam'),
            'spareParts' => DB::table('spareparts')->orderBy('nospareparts', 'desc')->paginate(10, ['*'], 'spareParts'),
        ]);
    }

    public function total(Request $request, ServiceDone $servicedone, ServicePending $servicepending, Kanibal $kanibal, Pinjam $pinjam, SpareParts $spareParts)
    {
        $servicedone = ServiceDone::count();
        $servicepending = ServicePending::count();
        $kanibal = Kanibal::count();
        $pinjam = Pinjam::count();
        $spareParts = SpareParts::count();

        return view(
            'home',
            compact('service_dones', 'service_pendings', 'kanibals', 'pinjams', 'spareparts')
        );
    }
}
