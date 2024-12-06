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
        Schema::table('itar', function (Blueprint $table) {
            //
            $table->double("o_a")->nullable();
            $table->double("o_e")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itar', function (Blueprint $table) {
            //
            $table->dropColumn("o_a");
            $table->dropColumn("o_e");
        });
    }
};
