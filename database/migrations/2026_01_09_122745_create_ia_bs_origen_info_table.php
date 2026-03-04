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
        Schema::create('ia_bs_origen_info', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idBS');
            $table->integer('anio');
            $table->text('origen_informacion')->nullable();

            $table->timestamps();

            // Índices
            $table->unique(['idBS', 'anio'], 'uk_bs_anio');

            // Foreign key (opcional pero recomendable)
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
        Schema::dropIfExists('ia_bs_origen_info');
    }
};
