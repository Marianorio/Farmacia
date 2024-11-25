<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecetasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:recetas');
    }

    public function index()
    {
        return view('recetas.recetas');
    }
}
