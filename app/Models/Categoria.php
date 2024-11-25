<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
   public $timestamps = false;
   
   protected $fillable = [
       'nombre',
       'descripcion'
   ];
    protected $dates = [
       'fecha_creacion',
       'fecha_actualizacion'
   ];
    public function productos()
   {
       return $this->hasMany(Producto::class, 'id_categoria');
   }
}