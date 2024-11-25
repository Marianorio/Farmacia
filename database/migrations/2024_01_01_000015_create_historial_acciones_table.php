<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historial_acciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_accion', ['venta', 'compra', 'pedido', 'modificacion', 'eliminacion', 'adicion']);
            $table->integer('id_referencia')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('id_empleado')->nullable()->constrained('usuarios');
            $table->timestamp('fecha')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_acciones');
    }
};