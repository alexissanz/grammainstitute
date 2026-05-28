<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('glossary_terms', function (Blueprint $table) {
            if (! Schema::hasColumn('glossary_terms', 'letra')) {
                $table->string('letra', 8)->nullable()->after('slug');
                $table->index('letra');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'material_gratis')) {
                $table->boolean('material_gratis')->default(false)->after('vagas_por_turma');
            }
            if (! Schema::hasColumn('courses', 'certificacao_gratis')) {
                $table->boolean('certificacao_gratis')->default(false)->after('material_gratis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('glossary_terms', function (Blueprint $table) {
            if (Schema::hasColumn('glossary_terms', 'letra')) {
                $table->dropIndex(['letra']);
                $table->dropColumn('letra');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'certificacao_gratis')) {
                $table->dropColumn('certificacao_gratis');
            }
            if (Schema::hasColumn('courses', 'material_gratis')) {
                $table->dropColumn('material_gratis');
            }
        });
    }
};
