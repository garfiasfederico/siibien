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
        Schema::table('ia_presupuesto_trimestral', function (Blueprint $table) {

            $table->unsignedBigInteger('idComponente')
                ->nullable()
                ->after('programa_presupuestario_id');

            $table->string('componente_texto', 500)
                ->nullable()
                ->after('idComponente');

            $table->string('actividad_texto', 500)
                ->nullable()
                ->after('componente_texto');

            $table->foreign('idComponente', 'fk_ipt_componente')
                ->references('idComponente')
                ->on('componente_presupuestario')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ia_presupuesto_trimestral', function (Blueprint $table) {

            $table->dropForeign('fk_ipt_componente');

            $table->dropColumn([
                'idComponente',
                'componente_texto',
                'actividad_texto'
            ]);

        });
    }
};
