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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_ingreso', ['vehiculo','caminando'])->default('vehiculo')->nullable();
            $table->string('detalle')->nullable();
            $table->boolean('isAutorizado')->default(false)->nullable();
            $table->unsignedBigInteger('visitante_id');
            $table->unsignedBigInteger('vivienda_id');
            $table->unsignedBigInteger('autoriza_habitante_id');
            $table->unsignedBigInteger('ingresa_habitante_id');
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->unsignedBigInteger('tipo_visita_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign( 'visitante_id' )->references( 'id' )->on('visitantes')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'vivienda_id' )->references( 'id' )->on('viviendas')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'autoriza_habitante_id' )->references( 'id' )->on('habitantes')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'ingresa_habitante_id' )->references( 'id' )->on('habitantes')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'vehiculo_id' )->references( 'id' )->on('vehiculos')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'tipo_visita_id' )->references( 'id' )->on('tipo_visitas')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign( 'user_id' )->references( 'id' )->on('users')->noActionOnDelete()->noActionOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};