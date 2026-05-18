<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'logo_rodape')) {
                $table->string('logo_rodape')->nullable()->after('logo');
            }
        });

        Schema::table('hero_slides', function (Blueprint $table) {
            if (! Schema::hasColumn('hero_slides', 'tipo')) {
                $table->string('tipo', 16)->default('imagem')->after('ordem'); // imagem | video
            }
            if (! Schema::hasColumn('hero_slides', 'video')) {
                $table->string('video')->nullable()->after('imagem');
            }
            if (! Schema::hasColumn('hero_slides', 'poster')) {
                // optional video poster (image shown while loading)
                $table->string('poster')->nullable()->after('video');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'logo_rodape')) {
                $table->dropColumn('logo_rodape');
            }
        });

        Schema::table('hero_slides', function (Blueprint $table) {
            foreach (['tipo', 'video', 'poster'] as $col) {
                if (Schema::hasColumn('hero_slides', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
