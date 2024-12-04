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
        Schema::create('itar_bs', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion_bs")->nullable();
            $table->string("unidad_bs")->nullable();
            $table->double("bs1p")->nullable();
            $table->double("bs1r")->nullable();
            $table->double("bs2p")->nullable();
            $table->double("bs2r")->nullable();
            $table->double("bs3p")->nullable();
            $table->double("bs3r")->nullable();
            $table->double("bs4p")->nullable();
            $table->double("bs4r")->nullable();
            $table->bigInteger("idItar")->unsigned();
            $table->foreign("idItar")->references("id")->on("itar")->onDelete("cascade");
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
        Schema::dropIfExists('itar_bs');
    }
};
