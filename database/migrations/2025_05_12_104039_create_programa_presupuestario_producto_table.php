<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programa_presupuestario_producto', function (Blueprint $table) {
            $table->id('idProgramaProducto'); // Nombre 
            $table->unsignedBigInteger('idProducto')->nullable();
            $table->unsignedBigInteger('idPrograma')->nullable();
            $table->string('componente')->nullable();
            $table->string('actividad')->nullable();
            $table->year('anio')->nullable(); // Columna para el año

            // Relaciones
            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
            $table->foreign('idPrograma')->references('idPrograma')->on('programa_presupuestario')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('programa_presupuestario_producto');
    }
};
