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
        Schema::create('ia_bs', function (Blueprint $table) {
            $table->id("idBS");
            $table->string("nombreBS")->nullable();
            $table->string("descripcionBS")->nullable();
            $table->string("p_entrega",20)->nullable();
            $table->string("p_otro",20)->nullable();
            $table->string("unidad_medidaBS",30)->nullable();    
            $table->bigInteger("ia_id")->unsigned();
            $table->foreign("ia_id")->references("id")->on("informe_acciones")->onDelete("cascade");
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
        Schema::dropIfExists('ia_bs');
    }
};
