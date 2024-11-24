<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productos_obras_sociales', function (Blueprint $table) {
            // Agregar las columnas de timestamps
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('productos_obras_sociales', function (Blueprint $table) {
            // Eliminar las columnas en caso de rollback
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};