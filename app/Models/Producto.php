<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'descripcion', 
        'precio_compra', 
        'precio_venta', 
        'stock_inicial', 
        'stock_actual', 
        'stock_minimo', 
        'caducidad', 
        'id_categoria', 
        'id_proveedor'
    ];

    protected $dates = ['caducidad'];

    // Mutador para asegurar que el precio se guarde con 2 decimales
    public function setPrecioCompraAttribute($value)
    {
        $this->attributes['precio_compra'] = round($value, 2);
    }

    public function setPrecioVentaAttribute($value)
    {
        $this->attributes['precio_venta'] = round($value, 2);
    }

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function obrasSociales()
    {
        return $this->belongsToMany(ObraSocial::class, 'producto_obra_social')
                    ->withPivot('porcentaje_cobertura')
                    ->withTimestamps();
    }
}



