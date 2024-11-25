<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $table = 'obras_sociales';
    
    protected $fillable = [
        'nombre',
        'cuit',
        'fecha_convenio',
        'fecha_vencimiento_convenio'
    ];

    protected $dates = [
        'fecha_convenio',
        'fecha_vencimiento_convenio'
    ];

    // Relación con productos a través de la tabla pivot
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'obra_social_producto')
                    ->withPivot('porcentaje_cobertura')
                    ->withTimestamps();
    }
}