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
        Schema::create('programa_presupuestario', function (Blueprint $table) {
            $table->id("idPrograma");
            $table->string("clavePrograma",10)->nullable();
            $table->string("descripcionPrograma")->nullable();
            $table->integer("idObjetivoPED")->unsigned()->nullable();
            $table->year("anio")->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programa_presupuestario');
    }
};
