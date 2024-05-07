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
        Schema::create('ae', function (Blueprint $table) {
            $table->id();
            $table->string("numero",10);
            $table->string("cuadro");
            $table->integer("idTemaPED");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
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
        Schema::dropIfExists('ae');
    }
};
