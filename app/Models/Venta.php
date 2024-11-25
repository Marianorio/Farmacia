<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'fecha',
        'total',
        'estado'
    ];

    // Convertir estos campos a fechas automáticamente
    protected $dates = [
        'fecha',
        'created_at',
        'updated_at'
    ];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
