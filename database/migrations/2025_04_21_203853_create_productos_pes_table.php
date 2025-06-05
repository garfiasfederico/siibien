<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('productos_pes', function (Blueprint $table) {
            $table->id('idProducto');
            $table->string('nombre_producto');
            $table->integer('idDependencia');

            $table->foreign('idDependencia')
                ->references('idDependencia')
                ->on('dependencia')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_pes');
    }
};
