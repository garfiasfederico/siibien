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
        Schema::create('ia_bs_region', function (Blueprint $table) {
            $table->bigInteger("idBS")->unsigned();
            $table->year("anio");
            $table->foreign("idBS")->references("idBS")->on("ia_bs")->onDelete("cascade");
            $table->integer("h1")->unsigned()->nullable();
            $table->integer("h2")->unsigned()->nullable();
            $table->integer("h3")->unsigned()->nullable();
            $table->integer("h4")->unsigned()->nullable();
            $table->integer("m1")->unsigned()->nullable();
            $table->integer("m2")->unsigned()->nullable();
            $table->integer("m3")->unsigned()->nullable();
            $table->integer("m4")->unsigned()->nullable();
            $table->double("a1")->unsigned()->nullable();
            $table->double("a2")->unsigned()->nullable();
            $table->double("a3")->unsigned()->nullable();
            $table->double("a4")->unsigned()->nullable();
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
        Schema::dropIfExists('ia_bs_region');
    }
};
