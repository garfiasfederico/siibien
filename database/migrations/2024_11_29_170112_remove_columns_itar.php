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
        //
        Schema::table("itar",function (Blueprint $table){
            $table->dropColumn("descripcion_bs");
            $table->dropColumn("unidad_bs");
            $table->dropColumn("bs1p");
            $table->dropColumn("bs1r");
            $table->dropColumn("bs2p");
            $table->dropColumn("bs2r");
            $table->dropColumn("bs3p");
            $table->dropColumn("bs3r");
            $table->dropColumn("bs4p");
            $table->dropColumn("bs4r");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table("itar",function(Blueprint $table){
            $table->string("descripcion_bs")->nullable();
            $table->string("unidad_bs")->nullable();
            $table->double("bs1p")->nullable();
            $table->double("bs1r")->nullable();
            $table->double("bs2p")->nullable();
            $table->double("bs2r")->nullable();
            $table->double("bs3p")->nullable();
            $table->double("bs3r")->nullable();
            $table->double("bs4p")->nullable();
            $table->double("bs4r")->nullable();
        });
    }
};
