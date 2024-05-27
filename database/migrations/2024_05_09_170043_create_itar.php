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
        Schema::create('itar', function (Blueprint $table) {
            $table->id();
            $table->string("folio")->nullable();
            $table->date("fecha_envio")->nullable();
            $table->integer("idDependencia");
            $table->foreign("idDependencia")->references("idDependencia")->on("dependencia")->onDelete("cascade");
            $table->string("tipo");
            $table->char("reglas",2)->nullable();
            $table->string("nombre");
            $table->string("objetivo");
            $table->string("descripcion");
            $table->string("cobertura",10);
            $table->string("periodicidad");
            $table->string("anio_inicio",4);
            $table->string("ejercicio",4);
            $table->integer("idEjePED")->nullable();
            $table->integer("idTemaPED")->nullable();
            $table->integer("idObjetivoPED")->nullable();
            $table->integer("idEstrategiaPED")->nullable();
            $table->integer("idLAPED")->nullable();
            $table->foreign("idEjePED")->references("idEjePED")->on("ejeped")->onDelete("cascade");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->foreign("idObjetivoPED")->references("idObjetivoPED")->on("objetivoped")->onDelete("cascade");
            $table->foreign("idEstrategiaPED")->references("idEstrategiaPED")->on("estrategiaped")->onDelete("cascade");
            $table->foreign("idLAPED")->references("idLAPED")->on("lineaaccionped")->onDelete("cascade");
            $table->string("transversales")->nullable();
            $table->integer("idIndicador");
            $table->foreign("idIndicador")->references("idIndicador")->on("indicador")->onDelete("cascade");
            $table->string("descripcion_bs")->nullable();
            $table->string("unidad_bs")->nullable();
            $table->double("bs1p")->nullable();
            $table->double("bs1r")->nullable();
            $table->double("bs2p")->nullable();
            $table->double("bs2r")->nullable();
            $table->double("bs3p")->nullable();
            $table->double("bs3r")->nullable();
            $table->double("bs4p")->nullable();
            $table->double("bs4r")->nullable();
            $table->foreignId("idPoblacion")->nullable()->references("id")->on("itar_poblacion")->onDelete("cascade");
            $table->string("descripcion_pb")->nullable();
            $table->double("po")->nullable();
            $table->double("po_m")->nullable();
            $table->double("po_h")->nullable();
            $table->double("pb1_t")->nullable();
            $table->double("pb1_m")->nullable();
            $table->double("pb1_h")->nullable();
            $table->double("pb2_t")->nullable();
            $table->double("pb2_m")->nullable();
            $table->double("pb2_h")->nullable();
            $table->double("pb3_t")->nullable();
            $table->double("pb3_m")->nullable();
            $table->double("pb3_h")->nullable();
            $table->double("pb4_t")->nullable();
            $table->double("pb4_m")->nullable();
            $table->double("pb4_h")->nullable();
            $table->string("im_s")->nullable();
            $table->string("im_e")->nullable();
            $table->string("im_a")->nullable();
            $table->text("p_o")->nullable();
            $table->text("r_s")->nullable();
            $table->text("b_d")->nullable();
            $table->text("a_t")->nullable();
            $table->text("a_p")->nullable();
            $table->text("otro")->nullable();
            $table->string("periodo_reporte")->nullable();
            $table->foreignId("idUser")->references("id")->on("users")->onDelete("cascade")->nullable();
            $table->boolean("status")->default(1);
            $table->string("estado",10)->default("edicion");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itar');
    }
};
