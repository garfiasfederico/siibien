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
        Schema::create('itar_regiones', function (Blueprint $table) {
             $table->id();
             $table->foreignId("idRegion")->references("id")->on("regiones")->onDelete("cascade");
             $table->foreignId("idITAR")->references("id")->on("itar")->onDelete("cascade");
             $table->double("tp")->nullable();
             $table->double("tpm")->nullable();
             $table->double("tph")->nullable();
             $table->smallInteger("num_mun")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itar_regiones');
    }
};
