<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'fecha',
        'total',
        'id_empleado'
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
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(User::class, 'id_empleado');
    }

    // Relación con detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
