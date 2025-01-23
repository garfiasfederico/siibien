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
        Schema::create('ia_alineacion', function (Blueprint $table) {
            $table->bigInteger("ia_id")->unsigned();
            $table->integer("idEjePED")->nullable();
            $table->integer("idTemaPED")->nullable();
            $table->integer("idObjetivoPED")->nullable();
            //$table->integer("idEstrategiaPED")->nullable();
            $table->string("lineas")->nullable();
            $table->foreign("idEjePED")->references("idEjePED")->on("ejeped")->onDelete("cascade");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->foreign("idObjetivoPED")->references("idObjetivoPED")->on("objetivoped")->onDelete("cascade");
            //$table->foreign("idEstrategiaPED")->references("idEstrategiaPED")->on("estrategiaped")->onDelete("cascade");
            $table->string("ejes_trans")->nullable();
            $table->integer("idSector")->unsigned()->nullable();
            $table->integer("idObjetivoSector")->unsigned()->nullable();
            $table->integer("idEstrategiaSector")->unsigned()->nullable();
            $table->integer("idProductoSector")->unsigned()->nullable();
            $table->string("i_estrategicos")->nullable();
            //Pendiente las foraneas de las tablas de los sectoriales.            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_alineacion');
    }
};
