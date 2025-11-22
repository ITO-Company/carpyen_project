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
        Schema::create('producto_proyectos', function (Blueprint $table) {
          $table->id('id');

            $table->integer('cantidad')->nullable();
            $table->integer('sobrante')->nullable();

            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->unsignedBigInteger('id_producto')->nullable();

            // Claves foráneas
            $table
                ->foreign('id_proyecto')
                ->references('id')
                ->on('proyectos')
                ->onDelete('cascade');

            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto_proyectos', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);
            $table->dropForeign(['id_producto']);
        });
        Schema::dropIfExists('producto_proyectos');
    }
};
