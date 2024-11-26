<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::table('ventas', function (Blueprint $table) {
           // Eliminar la clave foránea anterior
           $table->dropForeign(['id_empleado']);
           
           // Agregar la nueva clave foránea que apunta a users
           $table->foreign('id_empleado')
                 ->references('id')
                 ->on('users')
                 ->onDelete('restrict');
       });
   }
    public function down()
   {
       Schema::table('ventas', function (Blueprint $table) {
           $table->dropForeign(['id_empleado']);
           
           // Restaurar la clave foránea original
           $table->foreign('id_empleado')
                 ->references('id')
                 ->on('usuarios')
                 ->onDelete('restrict');
       });
   }
};
