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
        Schema::create('informe_acciones', function (Blueprint $table) {
            $table->id();
            $table->text("nombre");
            $table->integer("idDependencia");
            $table->foreign("idDependencia")->references("idDependencia")->on("dependencia")->onDelete("cascade");
            $table->integer("idTemaPED");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->string("alineacion_la")->nullable();
            $table->string("ae_cuadros")->nullable();
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
        Schema::dropIfExists('informe_acciones');
    }
};
