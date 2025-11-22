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
        Schema::create('proveedor_productos', function (Blueprint $table) {
            $table->id(); // id

            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();

            $table->unsignedBigInteger('id_proveedor')->nullable();
            $table->unsignedBigInteger('id_producto')->nullable();

            // Relaciones
            $table->foreign('id_proveedor')
                ->references('id')
                ->on('proveedors')
                ->onDelete('set null');

            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_productos');
    }
};
