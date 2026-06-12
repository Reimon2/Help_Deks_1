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
        Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        
        // 1. Relación con la tabla usuarios (¡Muy importante para tus 3 roles!)
        $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade');
        
        $table->string('name');
        $table->string('last_name');
        $table->string('subject');
        $table->string('priority');
        $table->string('department');
        $table->text('description');
        
        // 2. Estado del ticket (lo que venía del archivo add_status)
        $table->string('status')->default('open'); 

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
