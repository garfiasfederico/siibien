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
        Schema::table('informe_acciones', function (Blueprint $table) {
            $table->tinyInteger('vigente')
                ->default(1)
                ->after('prioritario');

            $table->year('anio')
                ->default(2025)
                ->after('vigente');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informe_acciones', function (Blueprint $table) {
            //
        });
    }
};
