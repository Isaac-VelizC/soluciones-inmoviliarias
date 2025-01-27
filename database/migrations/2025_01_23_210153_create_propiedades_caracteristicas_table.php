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
        Schema::create('caracteristicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
        });

        Schema::create('propiedades_caracteristicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_propiedad');
            $table->unsignedBigInteger('id_caracteristica');
            $table->foreign('id_propiedad')->references('id')->on('propiedades')->onDelete('cascade');
            $table->foreign('id_caracteristica')->references('id')->on('caracteristicas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristicas');
        Schema::dropIfExists('propiedades_caracteristicas');
    }
};
