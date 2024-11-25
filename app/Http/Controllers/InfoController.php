<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:info');
    }

    public function index()
    {
        return view('info.info');
    }
}
