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
            //
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->string('proxima_actualizacion')->nullable();
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
            $table->removeColumn('fecha_actualizacion');
            $table->removeColumn('proxima_actualizacion');
        });
    }
};
