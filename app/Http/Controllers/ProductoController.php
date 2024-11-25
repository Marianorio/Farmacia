<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $productos = Producto::with(['categoria', 'proveedor'])->select('productos.*');
            return DataTables::of($productos)
                ->addColumn('categoria.nombre', function($producto) {
                    return $producto->categoria ? $producto->categoria->nombre : '';
                })
                ->addColumn('proveedor.nombre', function($producto) {
                    return $producto->proveedor ? $producto->proveedor->nombre : '';
                })
                ->make(true);
        }
        return view('productos.productos');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar y crear el producto
            $producto = Producto::create($request->except('coberturas'));

            // Procesar coberturas
            if ($request->has('coberturas')) {
                $coberturas = json_decode($request->coberturas, true);
                $coberturasData = [];
                
                foreach ($coberturas as $obraSocialId => $descuento) {
                    $coberturasData[$obraSocialId] = ['descuento' => $descuento];
                }
                
                $producto->obrasSociales()->attach($coberturasData);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Producto guardado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'obrasSociales', 'proveedor'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $producto = Producto::findOrFail($id);
            $producto->update($request->except('coberturas'));

            // Actualizar coberturas
            if ($request->has('coberturas')) {
                $coberturas = json_decode($request->coberturas, true);
                $coberturasData = [];
                
                foreach ($coberturas as $obraSocialId => $descuento) {
                    $coberturasData[$obraSocialId] = ['descuento' => $descuento];
                }
                
                $producto->obrasSociales()->sync($coberturasData);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->obrasSociales()->detach();
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }
}

