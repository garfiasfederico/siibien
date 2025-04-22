<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alineacion_general_producto', function (Blueprint $table) {
            $table->id('idAlineacion');
            $table->unsignedBigInteger('idProducto')->nullable();
            $table->integer('idEjePED')->nullable();
            $table->integer('idTemaPED')->nullable();
            $table->integer('idObjetivoPED')->nullable();
            $table->integer('idEstrategiaPED')->nullable();
            $table->integer('idLAPED')->nullable();
            $table->unsignedBigInteger('idObjetivo')->nullable();
            $table->unsignedBigInteger('idEstrategia')->nullable();
            $table->unsignedBigInteger('idPrograma')->nullable();
            $table->string('componente')->nullable();
            $table->string('actividad')->nullable();
            $table->unsignedBigInteger('id')->nullable();
            $table->unsignedBigInteger('idBS')->nullable();
        
            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
            $table->foreign('idEjePED')->references('idEjePED')->on('ejeped')->onDelete('set null');
            $table->foreign('idTemaPED')->references('idTemaPED')->on('temaped')->onDelete('set null');
            $table->foreign('idObjetivoPED')->references('idObjetivoPED')->on('objetivoped')->onDelete('set null');
            $table->foreign('idEstrategiaPED')->references('idEstrategiaPED')->on('estrategiaped')->onDelete('set null');
            $table->foreign('idLAPED')->references('idLAPED')->on('lineaaccionped')->onDelete('set null');
            $table->foreign('idObjetivo')->references('idObjetivo')->on('objetivosector')->onDelete('set null');
            $table->foreign('idEstrategia')->references('idEstrategia')->on('estrategiasector')->onDelete('set null');
            $table->foreign('idPrograma')->references('idPrograma')->on('programa_presupuestario')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('informe_acciones')->onDelete('set null');
            $table->foreign('idBS')->references('idBS')->on('ia_bs')->onDelete('set null');
        });
        
        
    }

    public function down()
    {
        Schema::dropIfExists('alineacion_general_producto');
    }
};
