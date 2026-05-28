<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('font_body_family', 40)->nullable()->after('texto_rodape');
            $table->string('font_display_family', 40)->nullable()->after('font_body_family');
            $table->string('font_menu_family', 40)->nullable()->after('font_display_family');
            $table->string('font_course_family', 40)->nullable()->after('font_menu_family');
            $table->string('font_footer_family', 40)->nullable()->after('font_course_family');

            $table->unsignedSmallInteger('font_body_size')->nullable()->after('font_footer_family');
            $table->unsignedSmallInteger('font_menu_size')->nullable()->after('font_body_size');
            $table->unsignedSmallInteger('font_course_size')->nullable()->after('font_menu_size');
            $table->unsignedSmallInteger('font_title_size')->nullable()->after('font_course_size');
            $table->unsignedSmallInteger('font_footer_size')->nullable()->after('font_title_size');
            $table->unsignedSmallInteger('font_hero_intro_size')->nullable()->after('font_footer_size');
            $table->unsignedSmallInteger('font_hero_slide_size')->nullable()->after('font_hero_intro_size');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'font_body_family',
                'font_display_family',
                'font_menu_family',
                'font_course_family',
                'font_footer_family',
                'font_body_size',
                'font_menu_size',
                'font_course_size',
                'font_title_size',
                'font_footer_size',
                'font_hero_intro_size',
                'font_hero_slide_size',
            ]);
        });
    }
};
