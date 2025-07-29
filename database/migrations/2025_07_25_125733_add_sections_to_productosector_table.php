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
    // El 0 indica que la seccion esta bloqueada y el 1 que esta habilitada
    public function up()
    {
        Schema::table('productosector', function (Blueprint $table) {
            $table->boolean('seccion_ped')->default(0);
            $table->boolean('seccion_pes')->default(0);
            $table->boolean('seccion_ppa')->default(1);
            $table->boolean('seccion_DI')->default(0);
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
            $table->dropColumn(['seccion_ped', 'seccion_pes', 'seccion_ppa', 'seccion_DI']);
        });
    }

};
