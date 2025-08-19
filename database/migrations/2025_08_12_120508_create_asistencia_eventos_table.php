<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {


        Schema::create('asistencia_eventos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id('idAsistencia');

            $table->foreignId('idEvento')
                  ->constrained('eventos', 'idEvento')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('idRegistro')
                  ->constrained('registros', 'idRegistro')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->timestamp('scanned_at')->useCurrent();

            $table->unique(['idEvento', 'idRegistro'], 'uq_evento_registro');
            $table->index('idEvento', 'idx_asistencia_evento');
            $table->index('idRegistro', 'idx_asistencia_registro');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('asistencia_eventos');  // plural (el correcto)
        Schema::enableForeignKeyConstraints();
    }
};
