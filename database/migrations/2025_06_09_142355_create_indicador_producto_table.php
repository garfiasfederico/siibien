<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->string('tipo')->nullable();
            $table->string('metodo_calculo')->nullable();
            $table->string('frecuencia_medicion')->nullable();
            $table->string('sentido_esperado')->nullable();
            $table->string('unidad_medida_producto')->nullable();
            $table->string('unidad_medida_indicador')->nullable();
            $table->string('medio_verificacion_indicador')->nullable();
        
            $table->foreign('idProducto')->references('idProducto')->on('productosector')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicadores_producto');
    }
};
