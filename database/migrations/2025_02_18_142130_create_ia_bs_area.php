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
        Schema::create('ia_bs_area', function (Blueprint $table) {
            $table->bigInteger("idBS")->unsigned();
            $table->year("anio");
            $table->foreign("idBS")->references("idBS")->on("ia_bs")->onDelete("cascade"); 
            $table->double("arp1")->nullable();
            $table->double("ara1")->nullable();
            $table->double("arp2")->nullable();
            $table->double("ara2")->nullable();
            $table->double("arp3")->nullable();
            $table->double("ara3")->nullable();
            $table->double("arp4")->nullable();
            $table->double("ara4")->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_bs_area');
    }
};
