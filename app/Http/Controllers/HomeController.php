<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Pinjam;
use App\Models\Kanibal;
use App\Models\Service;
use Illuminate\View\View;
use App\Models\SpareParts;
use App\Models\ServiceDone;
use Illuminate\Http\Request;
use App\Models\ServicePending;
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
            'service' => DB::table('services')->orderBy('tanggalmasuk', 'desc')->paginate(10, ['*'], 'service'),
            'stock' => DB::table('stocks')->orderBy('tanggalmasuk', 'desc')->paginate(10, ['*'], 'stock'),
            'pinjam' => DB::table('pinjams')->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'pinjam'),
            'spareParts' => DB::table('spareparts')->orderBy('nospareparts', 'desc')->paginate(10, ['*'], 'spareParts'),
        ]);
    }

    public function total(Request $request, Service $service, Pinjam $pinjam, SpareParts $spareParts)
    {
        $service = Service::count();
        $stock = Stock::count();
        $pinjam = Pinjam::count();
        $spareParts = SpareParts::count();

        return view(
            'home',
            compact('services', 'pinjams', 'spareparts')
        );
    }

}
