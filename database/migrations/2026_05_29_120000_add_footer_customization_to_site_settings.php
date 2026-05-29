<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Footer height (vertical padding, in px) + per-text sizes (px).
            $table->unsignedInteger('footer_padding_top')->default(44)->after('font_footer_size');
            $table->unsignedInteger('footer_padding_bottom')->default(20)->after('footer_padding_top');
            $table->unsignedInteger('footer_email_size')->default(16)->after('footer_padding_bottom');
            $table->unsignedInteger('footer_credit_size')->default(16)->after('footer_email_size');
            $table->unsignedInteger('footer_copyright_size')->default(15)->after('footer_credit_size');
            $table->unsignedInteger('footer_tagline_size')->default(13)->after('footer_copyright_size');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_padding_top', 'footer_padding_bottom',
                'footer_email_size', 'footer_credit_size',
                'footer_copyright_size', 'footer_tagline_size',
            ]);
        });
    }
};
