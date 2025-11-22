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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_metro', 50)->nullable();
            $table->decimal('costo_metro', 10, 2)->nullable();
            $table->decimal('cantidad_metro', 10, 2)->nullable();
            $table->decimal('costo_muebles', 10, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('estado', 50)->nullable();
            $table->integer('numero_muebles')->nullable();
            $table->string('comentarios', 500)->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // FK a projects (si existe tabla projects)
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
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);
        });
        Schema::dropIfExists('cotizacions');
    }
};
