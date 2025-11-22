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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('descripcion', 500)->nullable();
            $table->string('ubicacion', 255)->nullable();
            $table->string('estado', 50)->nullable();

            // foreign keys (igual que en Java)
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            // Relaciones (opcionales pero recomendadas)
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('proyectos');
    }
};
