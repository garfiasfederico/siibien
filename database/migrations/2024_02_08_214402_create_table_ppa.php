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
        Schema::create('ppa', function (Blueprint $table) {
            $table->id();
            $table->string('periodo','5');
            $table->text('nombre');
            $table->text('objetivo');
            $table->text('descripcion');
            $table->string('cobertura',10);
            $table->string('alineacion_ped');
            $table->string('alineacion_pp');
            $table->string('fuente_financiamiento',100);
            $table->double('monto_inversion');
            $table->double('monto_ejercido');
            $table->text('descripcion_bs');
            $table->double('entregas_bs');
            $table->string('um_bs');
            $table->string('tipo_beneficiario',50);
            $table->text('descripcion_beneficiario');
            $table->string('poblacion_objetivo');
            $table->string('poblacion_atendida');
            $table->string('poblacion_atender');
            $table->string('regiones');
            $table->string('municipios')->nullable();
            $table->string('impacto_social')->nullable();
            $table->string('impacto_economico')->nullable();
            $table->string('impacto_ambiental')->nullable();
            $table->date('fecha_evento')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('dependencia_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('ppa');
    }
};
