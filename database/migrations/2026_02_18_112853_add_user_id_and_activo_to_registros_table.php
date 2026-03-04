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
    public function up(): void
    {
        Schema::table('registros', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->after('idRegistro');

            $table->boolean('activo')->default(1)->after('qr_uuid');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null') // si borran user, no afecta historial
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'activo']);
        });
    }
};
