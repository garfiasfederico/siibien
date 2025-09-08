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
        Schema::table('indicadorsector', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('idObjetivo')->nullable()->after('idSector');
            $table->unsignedBigInteger('idEstrategia')->nullable()->after('idObjetivo');

            $table->foreign('idObjetivo')
            ->references('idObjetivo')->on('objetivosector')
            ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('idEstrategia')
            ->references('idEstrategia')->on('estrategiasector')
            ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicadorsector', function (Blueprint $table) {
            //

            $table->dropForeign(['idObjetivo']);
            $table->dropForeign(['idEstrategia']);

            // luego eliminar columnas
            $table->dropColumn(['idObjetivo', 'idEstrategia']);
        });
    }
};
