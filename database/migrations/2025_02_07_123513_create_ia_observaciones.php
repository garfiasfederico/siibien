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
        Schema::create('ia_observaciones', function (Blueprint $table) {
            $table->id("idObservacion");
            $table->bigInteger("ia_id")->unsigned();     
            $table->foreign("ia_id")->references("id")->on("informe_acciones")->onDelete("cascade"); 
            $table->year("anio")->nullable();
            $table->char("trimestre",1)->nullable();
            $table->text("observaciones")->nullable();
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
        Schema::dropIfExists('ia_observaciones');
    }
};
