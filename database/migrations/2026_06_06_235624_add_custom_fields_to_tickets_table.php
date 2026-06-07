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
        Schema::table('tickets', function (PHPUnic\Blueprint $table) {
            // Estado del ticket: ahora incluimos 'escalado'
            // Lo ponemos por defecto en 'abierto'
            $table->enum('status', ['abierto', 'en_progreso', 'escalado', 'resuelto', 'cerrado'])->default('abierto')->change();
        
            // Campo para la dificultad que cambiarán el admin o analista
            $table->enum('dificultad', ['baja', 'media', 'alta'])->nullable()->after('status');
        
            // Campo para que el técnico escriba el porqué del escalado (Seguimiento)
            $table->text('comentario_escalado')->nullable()->after('dificultad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Si echamos para atrás, eliminamos los campos nuevos
            $table->dropColumn(['dificultad', 'comentario_escalado']);
        });
    }
};
