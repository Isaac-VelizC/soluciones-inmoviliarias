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
        Schema::create('hotspots', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->unsignedBigInteger('sceneId');
            $table->unsignedBigInteger('targetScene')->nullable(); // Imagen de destino
            $table->float('pitch');
            $table->float('yaw');
            $table->timestamps();
            $table->foreign('sceneId')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('targetScene')->references('id')->on('images')->onDelete('cascade');
            $table->unsignedBigInteger('propiedad_id')->nullable();
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspots');
    }
};
