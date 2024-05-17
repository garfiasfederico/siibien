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
        Schema::create('itar_medios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("idITAR")->references("id")->on("itar")->onDelete("cascade");
            $table->string("tipo")->nullable();
            $table->string("nombre")->nullable();
            $table->string("ubicacion")->nullable();
            $table->string("descripcion")->nullable();
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
        Schema::dropIfExists('itar_medios');
    }
};
