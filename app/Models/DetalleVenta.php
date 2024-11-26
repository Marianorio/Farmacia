<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    public $timestamps = false;
    
    protected $fillable = [
        'venta_id',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}