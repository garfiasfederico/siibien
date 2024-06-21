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
        Schema::create('informe_medios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("idParrafo")->references("id")->on("informe_parrafos")->onDelete("cascade");
            $table->string("nombre")->nullable();
            $table->string("ubicacion");
            $table->string("descripcion")->nullable();
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
        Schema::dropIfExists('informe_medios');
    }
};
