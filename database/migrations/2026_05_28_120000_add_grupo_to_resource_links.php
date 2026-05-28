<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resource_links', function (Blueprint $table) {
            // Sub-section grouping within a category (3rd level), e.g. "Beginner Grammar".
            $table->string('grupo', 160)->nullable()->after('category_id');
            $table->unsignedInteger('grupo_ordem')->default(0)->after('grupo');
        });
    }

    public function down(): void
    {
        Schema::table('resource_links', function (Blueprint $table) {
            $table->dropColumn(['grupo', 'grupo_ordem']);
        });
    }
};
