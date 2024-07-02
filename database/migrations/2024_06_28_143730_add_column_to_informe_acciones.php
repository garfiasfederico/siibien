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
            $table->tinyInteger("parrafos_max")->default(2)->nullable();
            $table->string("creacion",1)->default("a");
            $table->boolean("status")->default(1);
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
            $table->dropColumn("parrafos_max");
            $table->dropColumn("creacion");
            $table->dropColumn("status");

        });
    }
};
