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
        Schema::table('ae', function (Blueprint $table) {
            $table->string("clave",5)->nullable();
            $table->integer("idDependencia")->nullable();
            $table->foreign("idDependencia")->references("idDependencia")->on("dependencia")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ae', function (Blueprint $table) {
          $table->dropColumn("clave");
          $table->dropColumn("idDependencia");
        });
    }
};
