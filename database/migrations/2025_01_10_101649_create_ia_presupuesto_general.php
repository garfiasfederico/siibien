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
        Schema::create('ia_presupuesto_general', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("ia_id")->unsigned();
            $table->foreign("ia_id")->references("id")->on("informe_acciones")->onDelete("cascade");
            $table->year("anio");
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
        Schema::dropIfExists('ia_presupuesto_general');
    }
};
