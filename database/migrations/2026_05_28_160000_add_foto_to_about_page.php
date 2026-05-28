<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            // Portrait shown in the "Who is" section (storage path on the public disk).
            $table->string('foto')->nullable()->after('quote_author');
        });
    }

    public function down(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
