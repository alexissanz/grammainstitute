<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            // true = portrait shown in black & white; false = original colours.
            $table->boolean('foto_bw')->default(true)->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->dropColumn('foto_bw');
        });
    }
};
