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
            $table->decimal('programado', 15, 4)->nullable();
            $table->decimal('realizado', 15, 4)->nullable();
            $table->decimal('valor_indicador', 8, 4)->nullable();

            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento_metas');
    }
};
