<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('imagem')->nullable();

            // Translatable content
            $table->json('titulo');
            $table->json('subtitulo')->nullable();
            $table->json('descricao')->nullable();
            $table->json('badge_texto')->nullable();    // "-50%", "Black Week", "Anuidade 2026"
            $table->json('cta_texto')->nullable();      // "Garantir desconto"

            // Visual
            $table->string('cor_fundo', 10)->default('#1a1612');
            $table->string('cor_texto', 10)->default('#faf6ec');
            $table->string('cor_destaque', 10)->default('#c8a44b');

            // Action
            $table->string('cta_url', 500)->nullable();
            $table->string('codigo_promo', 60)->nullable();         // promo code if any
            $table->string('desconto', 60)->nullable();             // "50% OFF"

            // Schedule
            $table->dateTime('inicio')->nullable();
            $table->dateTime('fim')->nullable();

            // Where to show
            $table->boolean('mostrar_topbar')->default(false);      // top thin strip
            $table->boolean('mostrar_home')->default(true);          // full banner on home
            $table->boolean('mostrar_popup')->default(false);        // modal popup

            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);

            $table->timestamps();

            $table->index('ativo');
            $table->index(['inicio', 'fim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
