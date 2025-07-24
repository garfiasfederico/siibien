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
        Schema::table('matriz_coordinacion_2024', function (Blueprint $table) {
            //Copia la estructura
            DB::statement('CREATE TABLE matriz_coordinacion_2024 LIKE matriz_coordinacion');
            //Copiar los datos
            DB::statement('INSERT INTO matriz_coordinacion_2024 SELECT * FROM matriz_coordinacion');
            //Vaciar la tabla original (opcional)
            DB::statement('DELETE FROM matriz_coordinacion');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriz_coordinacion_2024');
    }
};
