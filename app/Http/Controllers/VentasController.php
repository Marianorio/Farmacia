<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\View;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->orderBy('id', 'desc')->get();
        $clientes = Cliente::all();
        $productos = Producto::where('stock_actual', '>', 0)->get();
        
        return view('ventas.ventas', compact('ventas', 'clientes', 'productos'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validar la solicitud
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'productos' => 'required|array',
                'productos.*.id' => 'required|exists:productos,id',
                'productos.*.cantidad' => 'required|integer|min:1'
            ]);

            // Crear la venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => now(),
                'estado' => 'COMPLETADA',
                'total' => 0
            ]);

            $total = 0;

            // Procesar cada producto
            foreach ($request->productos as $item) {
                $producto = Producto::find($item['id']);
                
                // Verificar stock
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: " . $producto->nombre);
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];
                
                // Crear detalle de venta
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal
                ]);
                
                // Actualizar stock
                $producto->stock_actual -= $item['cantidad'];
                $producto->save();
                
                $total += $subtotal;
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $total]);
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Venta creada exitosamente',
                'venta_id' => $venta->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show($id)
    {
        try {
            $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $venta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $venta = Venta::with('detalles')->find($id);
            
            // Restaurar stock de productos
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                $producto->stock_actual += $detalle->cantidad;
                $producto->save();
            }
            
            // Eliminar la venta (los detalles se eliminarán automáticamente por la relación)
            $venta->delete();
            
            DB::commit();
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function generarPDF($id)
    {
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        
        $pdf = PDF::loadView('facturas.factura', compact('venta'));
        
        return $pdf->download('factura-' . $venta->id . '.pdf');
    }
}