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
        Schema::create('seguimiento_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->integer('año');
            $table->string('programado')->nullable();
            $table->string('realizado')->nullable();
            $table->string('valor_indicador')->nullable();
        
            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
        });
        
        
    }

    public function down()
    {
        Schema::dropIfExists('seguimiento_metas');
    }
};
