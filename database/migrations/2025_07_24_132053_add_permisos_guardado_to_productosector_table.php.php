<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermisosGuardadoToProductosectorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('productosector', function (Blueprint $table) {
            $table->boolean('guardar_generales')->default(1)->after('estado_producto');
            $table->boolean('guardar_seguimiento')->default(0)->after('guardar_generales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('productosector', function (Blueprint $table) {
            $table->dropColumn('guardar_generales');
            $table->dropColumn('guardar_seguimiento');
        });
    }
}
