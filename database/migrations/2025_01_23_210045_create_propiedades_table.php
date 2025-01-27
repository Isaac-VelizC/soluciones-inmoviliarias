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

        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('direccion', 200);
            $table->string('ciudad', 50);
            $table->string('estado', 50)->nullable();
            $table->string('codigo_postal', 20)->nullable();
            $table->string('pais', 50)->nullable();
            $table->unsignedBigInteger('tipo_propiedad')->nullable();
            $table->foreign('tipo_propiedad')->references('id')->on('propiedades_tipo')->onDelete('set null');
            $table->unsignedBigInteger('tipo_traspaso')->nullable();
            $table->foreign('tipo_traspaso')->references('id')->on('ventas_tipo')->onDelete('set null');
            $table->integer('num_habitaciones');
            $table->integer('num_dormitorios')->default(1);
            $table->integer('num_salas')->default(1);
            $table->integer('num_banos')->default(0);
            $table->integer('num_cocinas')->default(0);
            $table->integer('num_garajes')->default(0);
            $table->decimal('superficie_construida', 10, 2);
            $table->decimal('superficie_terreno', 10, 2)->nullable();
            $table->integer('ano_construccion')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 12, 2);
            $table->string('moneda', 3);
            $table->string('financiamiento_bancario', 50)->nullable();
            $table->string('estatus', 50);
            $table->date('fecha_listado');
            $table->date('fecha_final')->nullable();
            $table->string('latitud', 50)->nullable();
            $table->string('longitud', 20)->nullable();
            $table->string('publicidad_estado', 20)->default('no');
            $table->unsignedBigInteger('id_propietario')->nullable();
            $table->foreign('id_propietario')->references('id')->on('propietarios')->onDelete('set null');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedades');
    }
};
