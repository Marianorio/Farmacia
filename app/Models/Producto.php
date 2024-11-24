<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre', 'descripcion', 'precio_compra', 'precio_venta', 
        'stock_inicial', 'stock_actual', 'stock_minimo', 'caducidad', 
        'id_categoria', 'id_proveedor'
    ];

    // Opcionalmente, si deseas formatear la fecha de caducidad
    protected $dates = ['caducidad'];

    // Agreguemos las relaciones necesarias para las ventas
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}



