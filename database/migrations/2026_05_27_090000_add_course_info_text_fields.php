<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'material_gratis_texto')) {
                $table->string('material_gratis_texto', 180)->nullable()->after('material_gratis');
            }
            if (! Schema::hasColumn('courses', 'certificacao_gratis_texto')) {
                $table->string('certificacao_gratis_texto', 180)->nullable()->after('certificacao_gratis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'certificacao_gratis_texto')) {
                $table->dropColumn('certificacao_gratis_texto');
            }
            if (Schema::hasColumn('courses', 'material_gratis_texto')) {
                $table->dropColumn('material_gratis_texto');
            }
        });
    }
};
