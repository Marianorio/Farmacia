<?php

namespace App\Http\Controllers;

use App\Models\ObraSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Schema;

class ObraSocialController extends Controller
{
    public function index()
    {
        try {
            if (request()->ajax()) {
                $obras_sociales = ObraSocial::select([
                    'id',
                    'nombre',
                    'cuit',
                    DB::raw('DATE(fecha_convenio) as fecha_convenio'),
                    'fecha_vencimiento_convenio'
                ])->get();
                
                return response()->json([
                    'data' => $obras_sociales
                ]);
            }
            
            return view('obras_sociales.obras_sociales');
        } catch (\Exception $e) {
            \Log::error('Error en ObraSocialController@index: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al cargar las obras sociales');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'cuit' => 'required|string|max:20|unique:obras_sociales,cuit',
                'fecha_convenio' => 'required|date',
                'fecha_vencimiento_convenio' => 'required|date|after:fecha_convenio'
            ]);

            DB::beginTransaction();
            
            $obraSocial = ObraSocial::create($request->all());
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Obra Social creada exitosamente',
                'data' => $obraSocial
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la Obra Social: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'cuit' => 'required|string|max:20|unique:obras_sociales,cuit,' . $id,
                'fecha_convenio' => 'required|date',
                'fecha_vencimiento_convenio' => 'required|date|after:fecha_convenio'
            ]);

            DB::beginTransaction();
            
            $obraSocial = ObraSocial::findOrFail($id);
            $obraSocial->update($request->all());
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Obra Social actualizada exitosamente',
                'data' => $obraSocial
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la Obra Social: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        \Log::info('Intentando eliminar Obra Social con ID: ' . $id);
        try {
            DB::beginTransaction();
            
            $obraSocial = ObraSocial::findOrFail($id);
            \Log::info('Obra Social encontrada:', $obraSocial->toArray());
            
            $obraSocial->delete();
            \Log::info('Obra Social eliminada correctamente');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Obra Social eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en ObraSocialController@destroy: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la Obra Social: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $obraSocial = ObraSocial::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $obraSocial
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la Obra Social: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProductos($id)
    {
        try {
            $obraSocial = ObraSocial::with(['productos' => function($query) {
                $query->select('productos.*', 'productos_obras_sociales.descuento');
            }])->findOrFail($id);

            return response()->json([
                'success' => true,
                'obraSocial' => [
                    'id' => $obraSocial->id,
                    'nombre' => $obraSocial->nombre
                ],
                'data' => $obraSocial->productos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los productos: ' . $e->getMessage()
            ], 500);
        }
    }
}