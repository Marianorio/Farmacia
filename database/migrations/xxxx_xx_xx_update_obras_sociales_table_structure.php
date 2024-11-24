<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('obras_sociales');
        
        Schema::create('obras_sociales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('cuit', 20);
            $table->date('fecha_convenio');
            $table->date('fecha_vencimiento_convenio');
            $table->timestamps(); // Agrega created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('obras_sociales');
    }
}; 