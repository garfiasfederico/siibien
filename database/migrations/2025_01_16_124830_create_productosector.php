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
        Schema::create('productosector', function (Blueprint $table) {
            $table->id("idProducto");
            $table->string("claveProducto",15)->nullable();
            $table->string("producto")->nullable();
            $table->foreignId("idEstrategia")->references("idEstrategia")->on("estrategiasector")->onDelete("cascade");            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productosector');
    }
};
