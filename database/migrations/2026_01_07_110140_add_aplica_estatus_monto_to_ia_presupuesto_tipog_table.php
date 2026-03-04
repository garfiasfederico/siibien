<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ia_presupuesto_tipog', function (Blueprint $table) {

            $table->boolean('aplica')
                ->default(false)
                ->after('actividad');
            // 0=No aplica, 1=No disponible, 2=Aplica
            $table->tinyInteger('estatus')
                ->nullable()
                ->after('aplica');

            $table->decimal('monto', 15, 2)
                ->nullable()
                ->after('estatus');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ia_presupuesto_tipog', function (Blueprint $table) {
            $table->dropColumn(['aplica', 'estatus', 'monto']);
        });
    }
};
