<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $proveedores = Proveedor::select('id', 'nombre')->get();
            return response()->json($proveedores);
        }
        
        $proveedores = Proveedor::all();
        return view('proveedores.proveedores', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'contacto' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
        ]);

        $proveedor = Proveedor::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Proveedor creado exitosamente',
            'proveedor' => $proveedor
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'contacto' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:proveedores,email,'.$id,
        ]);

        $proveedor = Proveedor::find($id);
        $proveedor->update($request->all());
        return response()->json(['success' => 'Proveedor actualizado correctamente']);
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->delete();
        return response()->json(['success' => 'Proveedor eliminado correctamente']);
    }

    public function getProveedores()
    {
        $proveedores = Proveedor::select('id', 'nombre')->get();
        return response()->json($proveedores);
    }

    public function productos($id)
    {
        try {
            $proveedor = Proveedor::with(['productos.categoria'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'productos' => $proveedor->productos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los productos: ' . $e->getMessage()
            ], 500);
        }
    }
}
