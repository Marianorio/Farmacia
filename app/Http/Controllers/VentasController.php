<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\View;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                'id_cliente' => 'required|exists:clientes,id',
                'productos' => 'required|array',
                'productos.*.id' => 'required|exists:productos,id',
                'productos.*.cantidad' => 'required|integer|min:1'
            ]);

            // Crear la venta
            $venta = new Venta();
            $venta->id_cliente = $request->id_cliente;
            $venta->fecha = now();
            $venta->total = 0;
            $venta->id_empleado = auth()->id();
            $venta->save();

            $total = 0;

            // Procesar cada producto
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                
                // Verificar stock
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: " . $producto->nombre);
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];
                
                // Crear detalle de venta
                DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $item['id'],
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
            $venta->total = $total;
            $venta->save();
            
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

    public function show(Venta $venta)
    {
        try {
            // Cargar las relaciones necesarias
            $venta->load(['cliente', 'detalles.producto']);
            
            // Debug detallado
            Log::info('ID de la venta:', ['id' => $venta->id]);
            Log::info('Cliente:', ['cliente' => $venta->cliente]);
            Log::info('Detalles:', ['detalles' => $venta->detalles]);
            Log::info('Fecha:', ['fecha' => $venta->fecha]);
            Log::info('Total:', ['total' => $venta->total]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $venta->id,
                    'cliente' => $venta->cliente,
                    'fecha' => $venta->fecha,
                    'total' => $venta->total,
                    'detalles' => $venta->detalles->map(function($detalle) {
                        return [
                            'producto' => $detalle->producto,
                            'cantidad' => $detalle->cantidad,
                            'precio_unitario' => $detalle->precio_unitario,
                            'subtotal' => $detalle->subtotal
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error en show:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los detalles de la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Venta $venta)
    {
        try {
            DB::beginTransaction();
            
            // Eliminar los detalles primero
            $venta->detalles()->delete();
            // Eliminar la venta
            $venta->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Venta eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la venta'
            ], 500);
        }
    }

    public function generarPDF(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto']);
        $pdf = PDF::loadView('facturas.factura', compact('venta'));
        return $pdf->stream('factura-' . $venta->id . '.pdf');
    }
}