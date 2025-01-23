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
        Schema::create('indicadorsector', function (Blueprint $table) {
            $table->integer("idIndicador");
            $table->smallInteger("idSector")->unsigned();
            $table->foreign("idIndicador")->references("idIndicador")->on("indicador")->onDelete("cascade");
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
        Schema::dropIfExists('indicadorsector');
    }
};
