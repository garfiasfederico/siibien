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
        Schema::create('objetivosector', function (Blueprint $table) {
            $table->id("idObjetivo");
            $table->string("claveObjetivo",10)->nullable();
            $table->string("objetivo")->nullable();
            $table->foreignId("idSubsector")->references("idSubsector")->on("subsectores")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetivosector');
    }
};
