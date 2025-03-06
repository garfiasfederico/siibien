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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id("idMunicipio");
            $table->string("clave",3);
            $table->string("municipio");
            $table->bigInteger("idRegion")->unsigned();
            $table->foreign("idRegion")->references("id")->on("regiones")->onDelete("cascade");            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
};
