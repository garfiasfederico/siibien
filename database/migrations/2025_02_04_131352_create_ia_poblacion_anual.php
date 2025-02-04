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
        Schema::create('ia_poblacion_anual', function (Blueprint $table) {
            $table->bigInteger("idPoblacion")->unsigned();            
            $table->foreign("idPoblacion")->references("idPoblacion")->on("ia_poblacion")->onDelete("cascade");
            $table->year("anio");
            $table->double("mujeres")->nullable();
            $table->double("hombres")->nullable();
            $table->double("total")->nullable();
            $table->string("impacto_esperado",)->nullable();
            $table->text("descripcion_impacto",)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_poblacion_anual');
    }
};
