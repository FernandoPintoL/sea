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
        Schema::create('viviendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id')->nullable();
            $table->boolean('vivienda_ocupada')->default(false)->nullable();
            $table->unsignedBigInteger('nroVivienda')->default(0)->nullable();
            $table->string('detalle')->default("")->nullable();
            $table->unsignedBigInteger('nroEspacios')->nullable();
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->unsignedBigInteger('tipo_vivienda_id')->default(0)->nullable();
            $table->timestamps();
            $table->foreign( 'perfil_id' )->references( 'id' )->on('perfils')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'condominio_id' )->references( 'id' )->on('condominios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign( 'tipo_vivienda_id' )->references( 'id' )->on('tipo_viviendas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viviendas');
    }
};