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
        Schema::create('medios_verificacion', function (Blueprint $table) {
            $table->bigIncrements('idMedio');  // ID personalizado
            $table->unsignedBigInteger('idProducto');
            $table->smallInteger('anio');
            $table->string('nombreArchivo', 255);
            $table->string('rutaArchivo', 500);
            $table->text('descripcion')->nullable();

            $table->timestamps();

            $table->foreign('idProducto')->references('idProducto')->on('productos_pes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medios_verificacion');
    }
};
