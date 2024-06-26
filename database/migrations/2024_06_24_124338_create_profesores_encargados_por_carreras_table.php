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
        Schema::create('profesores_encargados_por_carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('carrera', 45);
            $table->unsignedInteger('profesor_id');
            $table->timestamps();
    
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesores_encargados_por_carreras');
    }
};
