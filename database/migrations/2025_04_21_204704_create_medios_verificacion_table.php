<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medios_verificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->integer('año');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('idMedio')->nullable();
        
            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
            $table->foreign('idMedio')->references('idMedio')->on('ia_medios')->onDelete('set null');
        });
        
        
    }

    public function down()
    {
        Schema::dropIfExists('medios_verificacion');
    }
};
