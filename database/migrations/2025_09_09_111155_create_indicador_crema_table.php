<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicador_crema', function (Blueprint $table) {
            $table->bigIncrements('idValidacionCrema');

            $table->integer('idIndicador');

            // Solo una validación por indicador
            $table->unique('idIndicador');

            $table->foreign('idIndicador')
                  ->references('idIndicador')->on('indicador')
                  ->onDelete('cascade');

            // Criterios CREMA (0/1)
            $table->boolean('claro')->default(false);
            $table->boolean('relevante')->default(false);
            $table->boolean('economico')->default(false);
            $table->boolean('monitoreable')->default(false);
            $table->boolean('adecuado')->default(false);
            $table->boolean('aporteMarginal')->default(false);

            // Timestamps para saber cuándo se creó/actualizó
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicador_crema');
    }
};
