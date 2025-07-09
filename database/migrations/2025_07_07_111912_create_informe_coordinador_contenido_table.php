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
        Schema::create('informe_coordinador_contenido', function (Blueprint $table) {
            $table->id('idInformeCT');

            // Usamos signed integers porque las tablas externas también lo son
            $table->integer('idDependencia');
            $table->integer('idTemaPED');

            $table->enum('seccion', ['introduccion', 'conclusion']);
            $table->text('parrafo');
            $table->unsignedTinyInteger('orden')->default(1);
            $table->year('anio');

            $table->timestamps();

            // Índice único para evitar duplicados por sección, orden, dependencia, tema y año
            $table->unique(['idDependencia', 'idTemaPED', 'seccion', 'orden', 'anio'], 'idx_unico_parrafo_ct');

            // Claves foráneas
            $table->foreign('idDependencia', 'fk_icc_dependencia')
                  ->references('idDependencia')->on('dependencia')->onDelete('cascade');

            $table->foreign('idTemaPED', 'fk_icc_tema')
                  ->references('idTemaPED')->on('temaped')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informe_coordinador_contenido');
    }

};
