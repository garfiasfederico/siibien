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
        Schema::table('productosector', function (Blueprint $table) {
            $table->string('estado_producto')->default('activo')->after('idEstrategia');
            // Agregar columna idDependencia con clave foránea
            $table->integer('idDependencia')->nullable()->after('estado_producto');

            $table->foreign('idDependencia')
                ->references('idDependencia')
                ->on('dependencia')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productosector', function (Blueprint $table) {
            $table->dropForeign(['idDependencia']);
            $table->dropColumn('idDependencia');
            $table->dropColumn('estado_producto');
        });
    }
};
