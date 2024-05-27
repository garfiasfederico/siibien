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
        Schema::table('informe_parrafos', function (Blueprint $table) {
           $table->dropForeign("informe_parrafos_dependencias_id_foreign");
           $table->dropColumn("dependencias_id");
           $table->dropForeign("informe_parrafos_idtemaped_foreign");
           $table->dropColumn("idTemaPED");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informe_parrafos', function (Blueprint $table) {
            $table->integer("idTemaPED");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->integer("dependencias_id");
            $table->foreign("dependencias_id")->references("idDependencia")->on("dependencia")->onDelete("cascade");
        });
    }
};
