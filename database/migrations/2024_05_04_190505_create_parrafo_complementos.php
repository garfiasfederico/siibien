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
        Schema::create('parrafo_complementos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("informe_parrafos_id")->references("id")->on("informe_parrafos")->onDelete("cascade");
            $table->string("nombre_archivo")->nullable();
            $table->string("descripcion")->nullable();
            $table->string("ubicacion")->nullable();
            $table->boolean("status")->default(1);
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
        Schema::dropIfExists('parrafo_complementos');
    }
};
