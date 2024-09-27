<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Check if the authenticated user has the role of 'supir'
        if (Auth::user()->hasAnyRole(['supir'])); {
            // Redirect to stock.pengiriman.pelanggan.index if role is 'supir'
            return route('stock.pengirimanPelanggan');
        }

        // Redirect to Home if role is not 'supir'
        return RouteServiceProvider::HOME;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
