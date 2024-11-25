<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cuentas_corrientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->nullable()->constrained('clientes');
            $table->decimal('saldo', 10, 2)->default(0.00);
            $table->boolean('descuento_familiar')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuentas_corrientes');
    }
};