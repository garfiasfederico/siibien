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
        Schema::create('ia_problacion_general', function (Blueprint $table) {
            $table->bigInteger("ia_presupuesto_general_id")->unsigned();
            $table->bigInteger("tipo_poblacion_id")->unsigned();
            $table->string("tipo_poblacion_otro")->nullable();
            $table->string("descripcion_poblacion")->nullable();
            $table->double("poblacion_total")->nullable();
            $table->double("poblacion_mujeres")->nullable();
            $table->double("poblacion_hombres")->nullable();
            $table->string("impacto_esperado")->nullable();
            $table->string("descripcion_impacto")->nullable();
            $table->foreign("ia_presupuesto_general_id")->references("id")->on("ia_presupuesto_general")->onDelete("cascade");
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
        Schema::dropIfExists('ia_problacion_general');
    }
};
