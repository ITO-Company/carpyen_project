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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            
            $table->date('fecha')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('estado', 50)->nullable();

            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_plan_pago')->nullable();

            // Relaciones (foreign keys)
            $table->foreign('id_cliente')
                ->references('id')
                ->on('clientes')
                ->onDelete('set null');

            $table->foreign('id_plan_pago')
                ->references('id')
                ->on('plan_pagos')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
