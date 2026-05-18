<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('glossary_terms', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('termo', 180);                       // Λόγος, אֱמֶת
            $table->string('transliteracao', 180)->nullable();  // lógos, emet
            $table->string('lingua', 20);                       // el / he / la / en
            $table->string('categoria', 100)->nullable();       // Filosofia, Bíblico, Gramática

            // Translatable
            $table->json('significado');                        // resumo curto por idioma
            $table->json('descricao')->nullable();              // texto longo / parágrafo
            $table->json('etimologia')->nullable();
            $table->json('exemplo_uso')->nullable();
            $table->json('citacao_classica')->nullable();
            $table->json('citacao_autor')->nullable();

            $table->string('imagem')->nullable();
            $table->integer('ordem')->default(0);
            $table->boolean('destaque')->default(false);
            $table->boolean('ativo')->default(true);

            $table->timestamps();

            $table->index(['lingua', 'ativo']);
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('glossary_terms');
    }
};
