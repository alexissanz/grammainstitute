<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'google_url')) {
                $table->string('google_url')->nullable()->after('tiktok');
            }
            if (! Schema::hasColumn('site_settings', 'wikipedia_url')) {
                $table->string('wikipedia_url')->nullable()->after('google_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'wikipedia_url')) {
                $table->dropColumn('wikipedia_url');
            }
            if (Schema::hasColumn('site_settings', 'google_url')) {
                $table->dropColumn('google_url');
            }
        });
    }
};
