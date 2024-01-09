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
            $table->double('pun2023')->nullable();
            $table->string('des2023')->nullable();
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
            $table->dropColumn('pun2023');
            $table->dropColumn('des2023');

        });
    }
};
