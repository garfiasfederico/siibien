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
        Schema::create('ia_fuente', function (Blueprint $table) {
            $table->id();
            $table->integer("fuente_id")->unsigned()->nullable();
            $table->double("monto_total")->nullable();
            $table->double("monto_federal")->nullable();
            $table->double("monto_estatal")->nullable();
            $table->double("monto_municipal")->nullable();
            $table->bigInteger("ia_presupuesto_tipog_id")->unsigned();
            $table->foreign("ia_presupuesto_tipog_id")->references("id")->on("ia_presupuesto_tipog")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_fuente');
    }
};
