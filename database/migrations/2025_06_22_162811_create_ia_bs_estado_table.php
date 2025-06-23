<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIaBsEstadoTable extends Migration
{
    public function up()
    {
        Schema::create('ia_bs_estado', function (Blueprint $table) {
            $table->bigIncrements('idEstado'); 
            $table->unsignedBigInteger('idBs'); 
            $table->integer('anio');
            $table->boolean('aplica')->default(1);

           
            $table->foreign('idBs')->references('idBS')->on('ia_bs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ia_bs_estado');
    }
}
