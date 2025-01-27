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
        Schema::create('ia_poblacion', function (Blueprint $table) {
            $table->id("idPoblacion")->unsigned();
            $table->bigInteger("ia_id")->unsigned();            
            $table->string("tipo",10)->nullable();
            $table->bigInteger("tipo_poblacion_id")->unsigned()->nullable();
            $table->string("tipo_poblacion_otro")->nullable();
            $table->string("nombre_enfoque")->nullable();
            $table->string("descripcion_poblacion")->nullable();
            $table->foreign("ia_id")->references("id")->on("informe_acciones")->onDelete("cascade");
            $table->foreign("tipo_poblacion_id")->references("id")->on("itar_poblacion")->onDelete("cascade"); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_poblacion');
    }
};
