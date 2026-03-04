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
    public function up(): void
    {
        Schema::create('ia_presupuesto_trimestral_actividad', function (Blueprint $table) {

            $table->unsignedBigInteger('idPresupuestoTrimestral');
            $table->unsignedBigInteger('idActividad');

            $table->timestamps();

            $table->primary(['idPresupuestoTrimestral', 'idActividad']);

            $table->foreign('idPresupuestoTrimestral', 'fk_ipt_act_presupuesto')
                ->references('idPresupuestoTrimestral')
                ->on('ia_presupuesto_trimestral')
                ->onDelete('cascade');

            $table->foreign('idActividad', 'fk_ipt_act_actividad')
                ->references('idActividad')
                ->on('actividad')
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
        Schema::dropIfExists('ia_presupuesto_trimestral_actividad');

    }
};
