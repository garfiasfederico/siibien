<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('alineacion_general_producto', function (Blueprint $table) {
            // Eliminar relación y columna idLAPED 
            if (Schema::hasColumn('alineacion_general_producto', 'idLAPED')) {
                $table->dropForeign(['idLAPED']);
                $table->dropColumn('idLAPED');
            }
        });

        Schema::table('alineacion_general_producto', function (Blueprint $table) {
            //  idLAPED como string
            $table->string('idLAPED')->nullable()->after('idEstrategiaPED');

            //  nueva columna idSector 
            $table->unsignedSmallInteger('idSector')->nullable()->after('idLAPED');
            $table->foreign('idSector')->references('idSector')->on('sectores')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('alineacion_general_producto', function (Blueprint $table) {
            // Eliminar columnas nuevas
            $table->dropForeign(['idSector']);
            $table->dropColumn('idSector');
            $table->dropColumn('idLAPED');
        });

        Schema::table('alineacion_general_producto', function (Blueprint $table) {
            // Restaurar idLAPED como integer con relación original
            $table->integer('idLAPED')->nullable()->after('idEstrategiaPED');
            $table->foreign('idLAPED')->references('idLAPED')->on('lineaaccionped')->onDelete('set null');
        });
    }
};
