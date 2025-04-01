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
        Schema::create('informe_acciones_temporal', function (Blueprint $table) {
            $table->id("idPPATemp");
            $table->text("nombre")->nullable();
            $table->string("objetivo")->nullable();
            $table->string("descripcion")->nullable();                        
            $table->string("tipo",8)->nullable();
            $table->boolean("r_o")->nullable()->default(null);
            $table->string("link_r_o")->nullable()->default(null);
            $table->integer("idEjePED")->nullable();
            $table->integer("idTemaPED")->nullable();
            $table->foreign("idEjePED")->references("idEjePED")->on("ejeped")->onDelete("cascade");
            $table->foreign("idTemaPED")->references("idTemaPED")->on("temaped")->onDelete("cascade");
            $table->string("estado",10)->nullable()->default("pendiente");
            $table->integer("idDependencia");
            $table->foreign("idDependencia")->references("idDependencia")->on("dependencia")->onDelete("cascade");
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
        Schema::dropIfExists('informe_acciones_temporal');
    }
};
