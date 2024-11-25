<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObrasSocialesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:obras_sociales');
    }

    public function index()
    {
        return view('obras_sociales.obras_sociales');
    }
}
