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
        Schema::create('disenos', function (Blueprint $table) {
            $table->id();

            $table->string('url_render', 500)->nullable();
            $table->string('plano_laminado', 500)->nullable();
            $table->boolean('aprobado')->nullable();
            $table->date('fecha_aprobacion')->nullable();
            $table->string('comentario', 500)->nullable();
            $table->unsignedBigInteger('id_cotizacion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Relaciones (FOREIGN KEYS)
            $table
                ->foreign('id_cotizacion')
                ->references('id')
                ->on('cotizacions')
                ->onDelete('cascade');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disenos', function (Blueprint $table) {
            $table->dropForeign(['id_cotizacion']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('disenos');
    }
};
