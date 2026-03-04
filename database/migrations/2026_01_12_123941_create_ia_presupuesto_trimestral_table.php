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
        Schema::create('ia_presupuesto_trimestral', function (Blueprint $table) {

            $table->bigIncrements('idPresupuestoTrimestral');

            $table->integer('anio');
            $table->unsignedBigInteger('idBS');
            $table->unsignedBigInteger('programa_presupuestario_id');
            $table->enum('tipo_gasto', ['operativo', 'inversion']);

            $table->decimal('t1', 14, 2)->nullable();
            $table->decimal('t2', 14, 2)->nullable();
            $table->decimal('t3', 14, 2)->nullable();
            $table->decimal('t4', 14, 2)->nullable();

            $table->timestamps();

            $table->unique(
                ['idBS', 'anio', 'programa_presupuestario_id', 'tipo_gasto'],
                'uk_bs_anio_programa_tipo'
            );

            $table->foreign('idBS')
                ->references('idBS')
                ->on('ia_bs')
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
        Schema::dropIfExists('ia_presupuesto_trimestral');
    }
};
