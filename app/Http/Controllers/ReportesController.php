<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:reportes');
    }

    public function index()
    {
        return view('reportes.reportes');
    }
}
