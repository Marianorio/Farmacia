<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::table('ventas', function (Blueprint $table) {
           // Primero eliminamos las restricciones de clave foránea
           $table->dropForeign(['cliente_id']);
           $table->dropForeign(['id_cliente']);
           
           // Luego eliminamos la columna cliente_id
           $table->dropColumn('cliente_id');
           
           // Aseguramos que id_cliente sea NOT NULL
           $table->unsignedBigInteger('id_cliente')->nullable(false)->change();
           
           // Recreamos la clave foránea
           $table->foreign('id_cliente')->references('id')->on('clientes');
       });
   }
    public function down()
   {
       Schema::table('ventas', function (Blueprint $table) {
           // Si necesitas revertir, volvemos a crear la columna cliente_id
           $table->unsignedBigInteger('cliente_id')->after('id');
           $table->foreign('cliente_id')->references('id')->on('clientes');
           
           // Hacemos id_cliente nullable de nuevo
           $table->unsignedBigInteger('id_cliente')->nullable()->change();
       });
   }
};
