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
        Schema::create('ia_bs_presupuesto', function (Blueprint $table) {
            $table->bigInteger("idBS")->unsigned();
            $table->year("anio");
            $table->char("tipo")->nullable();
            $table->foreign("idBS")->references("idBS")->on("ia_bs")->onDelete("cascade");
            $table->double("m1")->nullable();
            $table->double("m2")->nullable();
            $table->double("m3")->nullable();
            $table->double("m4")->nullable();
            $table->double("e1")->nullable();
            $table->double("e2")->nullable();
            $table->double("e3")->nullable();
            $table->double("e4")->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_bs_presupuesto');
    }
};
