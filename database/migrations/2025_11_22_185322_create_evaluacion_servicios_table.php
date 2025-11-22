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
        Schema::create('evaluacion_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('comentarios', 500)->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->integer('calificacion_diseno')->nullable();
            $table->integer('calificacion_tela')->nullable();
            $table->integer('calificacion_instalacion')->nullable();

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
        Schema::dropIfExists('evaluacion_servicios');
    }
};
