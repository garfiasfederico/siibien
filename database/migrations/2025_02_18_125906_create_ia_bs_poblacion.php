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
        Schema::create('ia_bs_poblacion', function (Blueprint $table) {
            $table->bigInteger("idBS")->unsigned();
            $table->year("anio");
            $table->foreign("idBS")->references("idBS")->on("ia_bs")->onDelete("cascade"); 
            $table->integer("ph1")->unsigned()->nullable();
            $table->integer("ah1")->unsigned()->nullable();
            $table->integer("ph2")->unsigned()->nullable();
            $table->integer("ah2")->unsigned()->nullable();
            $table->integer("ph3")->unsigned()->nullable();
            $table->integer("ah3")->unsigned()->nullable();
            $table->integer("ph4")->unsigned()->nullable();
            $table->integer("ah4")->unsigned()->nullable();
            $table->integer("pm1")->unsigned()->nullable();
            $table->integer("am1")->unsigned()->nullable();
            $table->integer("pm2")->unsigned()->nullable();
            $table->integer("am2")->unsigned()->nullable();
            $table->integer("pm3")->unsigned()->nullable();
            $table->integer("am3")->unsigned()->nullable();
            $table->integer("pm4")->unsigned()->nullable();
            $table->integer("am4")->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_bs_poblacion');
    }
};
