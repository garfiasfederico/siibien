<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEdicionToSeguimientoMetasTable extends Migration
{
    //Nota el 0 significa que esta blouqeado y el 1 significa que etsa habilitado para edicion
    public function up()
    {
        Schema::table('seguimiento_metas', function (Blueprint $table) {
            $table->boolean('edicion_programacion')->default(0)->after('valor_indicador');
        });

        // Todos los registros Existentes estaran bloqueados para edicion con = 0
        DB::table('seguimiento_metas')->update(['edicion_programacion' => 0]);
    }

    public function down()
    {
        Schema::table('seguimiento_metas', function (Blueprint $table) {
            $table->dropColumn('edicion_programacion');
        });
    }
}
