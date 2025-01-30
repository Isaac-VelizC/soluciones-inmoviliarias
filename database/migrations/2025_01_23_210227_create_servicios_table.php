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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente', 100)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->text('servicios_detalle')->nullable();
            $table->string('nombre_trabajador', 100)->nullable();
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('prueba')->nullable();
            $table->decimal('precio', 10, 5)->default(0);
            $table->string('estado', 50)->default('pendiente');
            $table->unsignedBigInteger('id_solicitud_servicio')->nullable();
            $table->foreign('id_solicitud_servicio')->references('id')->on('solicitud_servicios')->onDelete('cascade');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_de_servicio');
            $table->foreign('tipo_de_servicio')->references('id')->on('servicios_tipo')->onDelete('cascade');
            $table->unsignedBigInteger('id_propiedad');
            $table->foreign('id_propiedad')->references('id')->on('propiedades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
