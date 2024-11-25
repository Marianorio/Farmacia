<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Renombrar fecha_creacion a created_at si existe
            if (Schema::hasColumn('proveedores', 'fecha_creacion')) {
                $table->renameColumn('fecha_creacion', 'created_at');
            } else {
                $table->timestamp('created_at')->nullable();
            }
            
            // Agregar updated_at
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Si quieres revertir los cambios
            if (Schema::hasColumn('proveedores', 'created_at')) {
                $table->renameColumn('created_at', 'fecha_creacion');
            }
            $table->dropColumn('updated_at');
        });
    }
};
