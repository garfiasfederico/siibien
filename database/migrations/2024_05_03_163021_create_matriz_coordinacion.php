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
        Schema::create('matriz_coordinacion', function (Blueprint $table) {
            $table->foreignId("dependencias_id")->references("idDependencia")->on("dependencia")->onDelete("cascade");
            $table->char("informe",1)->default("2");
            $table->foreignId("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->char("tipo",2)->nullable();
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
        Schema::dropIfExists('matriz_coordinacion');
    }
};
