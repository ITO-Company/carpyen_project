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
        Schema::create('cronogramas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->integer('dias_estimados')->nullable();
            $table->string('estado', 50)->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // FK a proyectos (si existe tabla 'proyectos')
            $table->foreign('id_proyecto')
                ->references('id')
                ->on('proyectos')
                ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cronogramas');
    }
};
