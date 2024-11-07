<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VistaAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vista_admin()
    {
        return view('/vista_admin');
    }
}
