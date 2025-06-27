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
        Schema::table('programa_presupuestario_producto', function (Blueprint $table) {
            //
            DB::statement("ALTER TABLE programa_presupuestario_producto MODIFY componente VARCHAR(355) NULL");
            DB::statement("ALTER TABLE programa_presupuestario_producto MODIFY actividad VARCHAR(355) NULL");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programa_presupuestario_producto', function (Blueprint $table) {
            //Revertir a varchar 255
            DB::statement("ALTER TABLE programa_presupuestario_producto MODIFY componente VARCHAR(255) NULL");
            DB::statement("ALTER TABLE programa_presupuestario_producto MODIFY actividad VARCHAR(255) NULL");

        });
    }
};
