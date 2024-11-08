<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObrasSocialesController extends Controller
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
    public function obras_sociales()
    {
        return view('/obras_sociales');
    }
}
