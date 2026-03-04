<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ia_bs_estado', function (Blueprint $table) {

            $table->tinyInteger('app_dm')
                ->default(0)
                ->after('aplica');

            $table->text('just_dm')
                ->nullable()
                ->after('app_dm');

            $table->tinyInteger('app_dr')
                ->default(0)
                ->after('just_dm');

            $table->text('just_dr')
                ->nullable()
                ->after('app_dr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ia_bs_estado', function (Blueprint $table) {
            $table->dropColumn([
                'just_dr',
                'app_dr',
                'just_dm',
                'app_dm',
            ]);
        });
    }
};
