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
            $table->unsignedBigInteger('visita_id');
            $table->unsignedBigInteger('autoriza_habitante_id');
            $table->unsignedBigInteger('ingresa_habitante_id');
            $table->enum('tipo_ingreso', ['vehiculo','caminando'])->default('vehiculo')->nullable();
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->string('detalle')->nullable();
            $table->boolean('isAutorizado')->default(false)->nullable();
            $table->unsignedBigInteger('tipo_visita_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign( 'autoriza_habitante_id' )->references( 'id' )->on('habitantes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'ingresa_habitante_id' )->references( 'id' )->on('habitantes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'vehiculo_id' )->references( 'id' )->on('vehiculos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'tipo_visita_id' )->references( 'id' )->on('tipo_visitas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'user_id' )->references( 'id' )->on('users')->onDelete('cascade')->onUpdate('cascade');
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