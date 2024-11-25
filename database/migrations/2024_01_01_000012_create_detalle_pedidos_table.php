<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->foreignId('id_pedido')->constrained('pedidos');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('cantidad');
            $table->primary(['id_pedido', 'id_producto']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};