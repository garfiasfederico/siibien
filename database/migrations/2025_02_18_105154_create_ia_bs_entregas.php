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
        Schema::create('ia_bs_entregas', function (Blueprint $table) {
            $table->bigInteger("idBS")->unsigned();
            $table->year("anio");
            $table->double("p1")->nullable();
            $table->double("p2")->nullable();
            $table->double("p3")->nullable();
            $table->double("p4")->nullable();
            $table->double("r1")->nullable();
            $table->double("r2")->nullable();
            $table->double("r3")->nullable();
            $table->double("r4")->nullable();
            $table->foreign("idBS")->references("idBS")->on("ia_bs")->onDelete("cascade"); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_bs_entregas');
    }
};
