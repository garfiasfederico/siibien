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
        Schema::create('notificacion_usuario', function (Blueprint $table) {
            $table->bigInteger('idNotificacion')->unsigned();
            $table->bigInteger('idUser')->unsigned();
            $table->boolean('visto')->default(false);
            $table->date('fecha_visto')->nullable();
            $table->timestamps();
            $table->foreign('idNotificacion')->references('idNotificacion')->on('notificaciones');
            $table->foreign('idUser')->references('id')->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacion_usuario');
    }
};
