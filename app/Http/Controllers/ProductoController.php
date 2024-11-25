<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\ObraSocial;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:productos');
    }

    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor', 'obrasSociales'])->get();
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $obrasSociales = ObraSocial::all();
        
        return view('productos.productos', compact('productos', 'categorias', 'proveedores', 'obrasSociales'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_inicial' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'caducidad' => 'nullable|date',
            'id_categoria' => 'required|exists:categorias,id',
            'id_proveedor' => 'required|exists:proveedores,id',
            'obras_sociales' => 'array|nullable',
            'obras_sociales.*.id' => 'exists:obras_sociales,id',
            'obras_sociales.*.porcentaje_cobertura' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $producto = Producto::create($validatedData);

            if (!empty($request->obras_sociales)) {
                $obrasSocialesData = collect($request->obras_sociales)
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['porcentaje_cobertura' => $item['porcentaje_cobertura']]];
                    });
                $producto->obrasSociales()->sync($obrasSocialesData);
            }

            return response()->json(['success' => true, 'message' => 'Producto creado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el producto: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'proveedor', 'obrasSociales'])->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_inicial' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'caducidad' => 'nullable|date',
            'id_categoria' => 'required|exists:categorias,id',
            'id_proveedor' => 'required|exists:proveedores,id',
            'obras_sociales' => 'array|nullable',
            'obras_sociales.*.id' => 'exists:obras_sociales,id',
            'obras_sociales.*.porcentaje_cobertura' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $producto->update($validatedData);

            if ($request->has('obras_sociales')) {
                $obrasSocialesData = collect($request->obras_sociales)
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['porcentaje_cobertura' => $item['porcentaje_cobertura']]];
                    });
                $producto->obrasSociales()->sync($obrasSocialesData);
            }

            return response()->json(['success' => true, 'message' => 'Producto actualizado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el producto'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return response()->json(['success' => true, 'message' => 'Producto eliminado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el producto'], 500);
        }
    }
}

