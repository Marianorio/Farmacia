<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoObraSocialTable extends Migration
{
   public function up()
   {
       Schema::create('producto_obra_social', function (Blueprint $table) {
           $table->id();
           $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
           $table->foreignId('obra_social_id')->constrained('obras_sociales')->onDelete('cascade');
           $table->decimal('porcentaje_cobertura', 5, 2);
           $table->timestamps();
            // Índices
           $table->unique(['producto_id', 'obra_social_id']);
       });
   }
    public function down()
   {
       Schema::dropIfExists('producto_obra_social');
   }
}
