<?php

namespace App\Http\Controllers;

use App\Models\ObraSocial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function data()
    {
        try {
            $obras_sociales = ObraSocial::select(['id', 'nombre', 'cuit', 'fecha_convenio', 'fecha_vencimiento_convenio']);
            
            return DataTables::of($obras_sociales)
                ->editColumn('fecha_convenio', fn($obra) => $obra->fecha_convenio ? date('d/m/Y', strtotime($obra->fecha_convenio)) : '')
                ->editColumn('fecha_vencimiento_convenio', fn($obra) => $obra->fecha_vencimiento_convenio ? date('d/m/Y', strtotime($obra->fecha_vencimiento_convenio)) : '')
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('Error en ObrasSocialesController@data: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar los datos'], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cuit' => 'required|string|max:15',
            'fecha_convenio' => 'required|date',
            'fecha_vencimiento_convenio' => 'required|date|after:fecha_convenio'
        ]);

        ObraSocial::create($validated);
        return response()->json(['success' => true]);
    }

    public function show(ObraSocial $id)
    {
        return $id;
    }

    public function update(Request $request, ObraSocial $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cuit' => 'required|string|max:15',
            'fecha_convenio' => 'required|date',
            'fecha_vencimiento_convenio' => 'required|date|after:fecha_convenio'
        ]);

        $id->update($validated);
        return response()->json(['success' => true]);
    }

    public function destroy(ObraSocial $id)
    {
        $id->delete();
        return response()->json(['success' => true]);
    }

    public function productos(ObraSocial $id)
    {
        return $id->productos;
    }
}
