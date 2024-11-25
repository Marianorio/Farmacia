<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores');
            $table->foreignId('id_empleado')->nullable()->constrained('usuarios');
            $table->timestamp('fecha')->useCurrent();
            $table->decimal('total', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};