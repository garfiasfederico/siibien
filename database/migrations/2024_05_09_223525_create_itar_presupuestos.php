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
        Schema::create('itar_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("idITAR")->references("id")->on("itar")->onDelete("cascade");
            $table->smallInteger("idPrograma");
            $table->foreign("idPrograma")->references("idPrograma")->on("programaspresupuestales")->onDelete("cascade");
            $table->date("fecha_corte")->nullable();
            $table->char("ejercicio",4);
            $table->double("f1m")->nullable();
            $table->double("f2m")->nullable();
            $table->double("f3m")->nullable();
            $table->double("f4m")->nullable();
            $table->double("f1e")->nullable();
            $table->double("f2e")->nullable();
            $table->double("f3e")->nullable();
            $table->double("f4e")->nullable();
            $table->double("e1m")->nullable();
            $table->double("e2m")->nullable();
            $table->double("e3m")->nullable();
            $table->double("e4m")->nullable();
            $table->double("e1e")->nullable();
            $table->double("e2e")->nullable();
            $table->double("e3e")->nullable();
            $table->double("e4e")->nullable();
            $table->double("m1m")->nullable();
            $table->double("m2m")->nullable();
            $table->double("m3m")->nullable();
            $table->double("m4m")->nullable();
            $table->double("m1e")->nullable();
            $table->double("m2e")->nullable();
            $table->double("m3e")->nullable();
            $table->double("m4e")->nullable();
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
        Schema::dropIfExists('itar_presupuestos');
    }
};
