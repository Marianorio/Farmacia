<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar todos los productos
    public function index()
    {
        $productos = Producto::all(); // Obtener todos los productos de la base de datos
        return view('productos.index', compact('productos'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('productos.create');
    }

    // Método para almacenar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'stock_inicial' => 'required|integer',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'caducidad' => 'nullable|date',
            'id_categoria' => 'nullable|integer',
            'id_proveedor' => 'nullable|integer',
        ]);

        Producto::create($validatedData); // Crear el producto en la base de datos

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    // Método para mostrar el formulario de edición
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Método para actualizar un producto existente
    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'stock_inicial' => 'required|integer',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'caducidad' => 'nullable|date',
            'id_categoria' => 'nullable|integer',
            'id_proveedor' => 'nullable|integer',
        ]);

        $producto->update($validatedData); // Actualizar el producto

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    // Método para eliminar un producto
    public function destroy(Producto $producto)
    {
        $producto->delete(); // Eliminar el producto

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}

