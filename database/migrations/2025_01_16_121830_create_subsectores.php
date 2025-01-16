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
        Schema::create('subsectores', function (Blueprint $table) {
            $table->id("idSubsector");
            $table->string("claveSubsector",10)->nullable();
            $table->string("subsector")->nullable();
            $table->smallInteger("idSector")->unsigned();           
            $table->foreign("idSector")->references("idSector")->on("sectores")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subsectores');
    }
};
