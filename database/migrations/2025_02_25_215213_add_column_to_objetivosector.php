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
        Schema::table('objetivosector', function (Blueprint $table) {
            $table->smallInteger('idSector')->unsigned()->nullable();
            $table->foreign("idSector")->references("idSector")->on("sectores")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objetivosector', function (Blueprint $table) {
            $table->dropColumn("idSector");
        });
    }
};
