<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
       Schema::table('detalle_ventas', function (Blueprint $table) {
           // Primero eliminamos la clave foránea si existe
           $table->dropForeign(['id_venta']);
           
           // Renombramos la columna
           $table->renameColumn('id_venta', 'venta_id');
           
           // Recreamos la clave foránea
           $table->foreign('venta_id')
                 ->references('id')
                 ->on('ventas')
                 ->onDelete('cascade');
       });
   }
    public function down()
   {
       Schema::table('detalle_ventas', function (Blueprint $table) {
           $table->dropForeign(['venta_id']);
           $table->renameColumn('venta_id', 'id_venta');
           $table->foreign('id_venta')
                 ->references('id')
                 ->on('ventas')
                 ->onDelete('cascade');
       });
   }
};
