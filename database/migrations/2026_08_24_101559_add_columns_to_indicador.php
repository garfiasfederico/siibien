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
        Schema::table('indicador', function (Blueprint $table) {
            $table->double("pun2025")->nullable();
            $table->string("des2025",15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicador', function (Blueprint $table) {
            //
            $table->dropColumn("pun2025");
            $table->dropColumn("des2025");
        });
    }
};
