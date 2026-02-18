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
        Schema::table('eventos', function (Blueprint $table) {
            // Agrega la columna "Sede" a la tabla eventos
            $table->string('sede', 255)->nullable()->after('descripcion');

            $table->string('idDependencia_invitadas', 355)->nullable()->after('sede');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('sede', 'idDependencia_invitadas');
        });
    }
};
