<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            // PK
            $table->id('idRegistro'); // BIGINT UNSIGNED

            // FK a tabla 'dependencia' (INT firmado, como indicaste)
            $table->integer('idDependencia');
            $table->foreign('idDependencia')
                  ->references('idDependencia')->on('dependencia')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Datos visibles
            $table->string('nombre', 255);
            $table->string('cargo', 255);
            $table->string('email', 255);
            $table->string('telefono', 50)->nullable();
            $table->string('perfil', 255)->nullable();
            $table->string('tipo_enlace', 255)->nullable();

            // QR único de por vida
            $table->char('qr_uuid', 36);

            // Índices / restricciones
            $table->unique('qr_uuid', 'uq_registros_qr_uuid');
            $table->unique('email', 'uq_registros_email');   // 1 persona = 1 registro por email
            $table->index('idDependencia', 'idx_registros_dependencia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('registros');
        Schema::enableForeignKeyConstraints();
    }
};
