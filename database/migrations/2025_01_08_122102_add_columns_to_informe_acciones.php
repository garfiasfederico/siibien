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
        Schema::table('informe_acciones', function (Blueprint $table) {
            $table->string("objetivo")->nullable();
            $table->string("descripcion")->nullable();
            $table->string("cobertura",20)->nullable();            
            $table->year("anio_inicio")->nullable();
            $table->boolean("itar_seg")->default(true);
            $table->string("estado",10)->nullable();
            $table->string("tipo",8)->nullable();
            $table->boolean("r_o")->nullable()->default(null);
            $table->string("link_r_o")->nullable()->default(null);
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
            $table->dropColumn("objetivo");
            $table->dropColumn("descripcion");
            $table->dropColumn("cobertura");    
            $table->dropColumn("anio_inicio");
            $table->dropColumn("itar_seg");
            $table->dropColumn("estado");
            $table->dropColumn("tipo");
            $table->dropColumn("r_o");
            $table->dropColumn("link_r_o");
        });
    }
};
