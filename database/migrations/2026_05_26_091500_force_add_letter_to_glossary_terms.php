<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('glossary_terms', 'letra')) {
            Schema::table('glossary_terms', function (Blueprint $table) {
                $table->string('letra', 8)->nullable()->after('slug');
                $table->index('letra');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('glossary_terms', 'letra')) {
            Schema::table('glossary_terms', function (Blueprint $table) {
                $table->dropIndex(['letra']);
                $table->dropColumn('letra');
            });
        }
    }
};
