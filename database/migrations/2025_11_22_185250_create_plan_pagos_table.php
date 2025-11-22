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
        Schema::create('plan_pagos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->decimal('deuda_total', 12, 2)->nullable();
            $table->decimal('pagado_total', 12, 2)->nullable();
            $table->integer('numero_deuda')->nullable();
            $table->integer('numero_pagos')->nullable();

            $table->string('estado', 50)->nullable();

            // Foreign key
            $table ->foreign('id_proyecto')
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
        Schema::table('plan_pagos', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);
        });
        Schema::dropIfExists('plan_pagos');
    }
};
