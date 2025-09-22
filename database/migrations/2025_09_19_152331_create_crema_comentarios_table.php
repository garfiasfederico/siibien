<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crema_comentarios', function (Blueprint $table) {
            $table->bigIncrements('idComentario');

            // Relación con la validación
            $table->unsignedBigInteger('idValidacionCrema');

            // Criterio (las 6 letras de CREEMA)
            $table->enum('criterio', [
                'claro',
                'relevante',
                'economico',
                'monitoreable',
                'adecuado',
                'aporteMarginal',
            ]);

            // Texto del comentario
            $table->text('comentario');

            $table->timestamps();

            // Llave foránea
            $table->foreign('idValidacionCrema')
                  ->references('idValidacionCrema')
                  ->on('indicador_crema')
                  ->onDelete('cascade');

            // Índice compuesto útil
            $table->index(['idValidacionCrema', 'criterio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crema_comentarios');
    }
};
