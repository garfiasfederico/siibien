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
        Schema::table('ia_bs_presupuesto', function (Blueprint $table) {
            //
            $table->biginteger("idPrograma")->unsigned()->nullable();
            $table->string("componente")->nullable();
            $table->foreign("idPrograma")->references("idPrograma")->on("programa_presupuestario")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ia_bs_presupuesto', function (Blueprint $table) {
            //
            $table->dropColumn("idPrograma");
            $table->dropColumn("componente");

        });
    }
};
