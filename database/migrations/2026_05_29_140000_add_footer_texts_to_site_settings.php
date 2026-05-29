<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Editable footer texts (previously hardcoded in the layout).
            $table->string('footer_tagline_text', 255)->nullable()->after('footer_tagline_size');
            $table->string('footer_credit_text', 255)->nullable()->after('footer_tagline_text');
            $table->string('footer_credit_url', 500)->nullable()->after('footer_credit_text');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['footer_tagline_text', 'footer_credit_text', 'footer_credit_url']);
        });
    }
};
