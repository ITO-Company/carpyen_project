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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_final')->nullable();
            $table->string('descripcion', 500)->nullable();
            $table->string('estado', 50)->nullable();
            $table->unsignedBigInteger('id_cronograma')->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // FK a cronogramas (si existe tabla 'cronogramas')
            $table->foreign('id_cronograma')
                ->references('id')
                ->on('cronogramas')
                ->onDelete('set null');

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
        Schema::dropIfExists('tareas');
    }
};
