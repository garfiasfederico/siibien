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
        Schema::table('informe_acciones', function (Blueprint $table) {
            //
            $table->boolean("reporta4to")->default(true);
            $table->string("justificacion4to")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informe_acciones', function (Blueprint $table) {
            //
            $table->dropColumn("reporta4to");
            $table->dropColumn("justificacion4to");
        });
    }
};
