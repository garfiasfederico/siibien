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
            $table->boolean('meta')->default(true);
            $table->boolean('histo')->default(true);
            $table->boolean('prog')->default(true);
            $table->boolean('moni')->default(true);
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
            $table->dropColumn('meta');
            $table->dropColumn('histo');
            $table->dropColumn('prog');
            $table->dropColumn('moni');
        });
    }
};
