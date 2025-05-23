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
        Schema::create('ia_bs_municipios', function (Blueprint $table) {
            $table->foreignId("idBS")->references("idBS")->on("ia_bs");
            $table->string("clave_municipio",3);
            $table->year("anio");
            $table->char("trimestre",1);
            $table->integer("mujeres")->unsigned()->nullable();
            $table->integer("hombres")->unsigned()->nullable();
            $table->double("area")->unsigned()->nullable();
            $table->double("entregas")->unsigned()->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_bs_municipios');
    }
};
