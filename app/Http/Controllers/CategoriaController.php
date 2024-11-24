<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            Log::info('Intentando cargar categorías');
            
            // Usar Query Builder en lugar del modelo
            $categorias = DB::table('categorias')
                           ->select('id', 'nombre')
                           ->get();
            
            Log::info('Categorías encontradas:', $categorias->toArray());
            
            return response()->json($categorias);
            
        } catch (\Exception $e) {
            Log::error('Error en CategoriaController@index: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Error al cargar las categorías: ' . $e->getMessage()
            ], 500);
        }
    }
}