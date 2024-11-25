<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Proveedor extends Model
{

   public $timestamps = false;
   
   protected $table = 'proveedores';
    protected $fillable = [
       'nombre',
       'contacto',
       'direccion',
       'telefono',
       'email',
       'informacion_adicional'
   ];
    protected $dates = [
       'fecha_creacion',
       'fecha_actualizacion'
   ];
    public function productos()
   {
       return $this->hasMany(Producto::class, 'id_proveedor');
   }
}