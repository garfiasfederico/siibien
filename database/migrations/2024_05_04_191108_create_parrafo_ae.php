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
        Schema::create('parrafo_ae', function (Blueprint $table) {
            $table->foreignId("informe_parrafos_1d")->references("id")->on("informe_parrafos")->onDelete("cascade");
            $table->foreignId("ae")->references("id")->on("ae")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parrafo_ae');
    }
};
