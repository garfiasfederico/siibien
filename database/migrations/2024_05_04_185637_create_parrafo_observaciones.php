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
        Schema::create('parrafo_observaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId("users_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("informe_parrafos_id")->references("id")->on("informe_parrafos")->onDelete("cascade");
            $table->text("observaciones")->nullable();
            $table->char("estado",2)->default("in");
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
        Schema::dropIfExists('parrafo_observaciones');
    }
};
