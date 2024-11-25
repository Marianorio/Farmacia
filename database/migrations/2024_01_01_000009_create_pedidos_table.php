<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->nullable()->constrained('clientes');
            $table->timestamp('fecha')->useCurrent();
            $table->enum('estado', ['pendiente', 'completado']);
            $table->foreignId('id_empleado')->nullable()->constrained('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};