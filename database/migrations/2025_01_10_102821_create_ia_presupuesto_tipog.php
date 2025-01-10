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
        Schema::create('ia_presupuesto_tipog', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("ia_presupuesto_general_id")->unsigned();
            $table->foreign("ia_presupuesto_general_id")->references("id")->on("ia_presupuesto_general")->onDelete("cascade");
            $table->char("tipo_gasto");
            $table->integer("pp_id")->unsigned()->nullable();
            $table->string("componente",255)->nullable();
            $table->string("actividad",255)->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ia_presupuesto_tipog');
    }
};
