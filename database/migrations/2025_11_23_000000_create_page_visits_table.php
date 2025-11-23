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
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->unique(); // Nombre único de la página
            $table->string('page_route'); // Ruta de la página
            $table->integer('visit_count')->default(0); // Contador de visitas
            $table->timestamp('last_visited_at')->nullable(); // Última visita
            $table->timestamps();
            
            $table->index('page_name');
            $table->index('page_route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
