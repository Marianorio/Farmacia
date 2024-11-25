<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:proveedores');
    }

    public function index()
    {
        return view('proveedores.proveedores');
    }
}
