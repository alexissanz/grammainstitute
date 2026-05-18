<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('imagem')->nullable();

            // Translatable
            $table->json('titulo');
            $table->json('subtitulo')->nullable();
            $table->json('descricao')->nullable();
            $table->json('local_nome')->nullable();           // Auditório / Online / Address line 1

            // Date / time
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->string('timezone', 60)->default('America/Sao_Paulo');

            // Location details
            $table->string('local_endereco', 255)->nullable();
            $table->string('local_cidade', 100)->nullable();
            $table->string('formato', 30)->default('presencial');  // presencial / online / hibrido
            $table->string('link_online', 500)->nullable();

            // Pricing
            $table->boolean('gratuito')->default(true);
            $table->string('preco', 100)->nullable();              // displayable price string
            $table->decimal('preco_valor', 10, 2)->nullable();     // numeric price
            $table->string('moeda', 10)->default('BRL');

            // Registration
            $table->string('link_inscricao', 500)->nullable();
            $table->integer('vagas_total')->nullable();
            $table->integer('vagas_ocupadas')->default(0);

            // Speaker / host
            $table->string('palestrante_nome', 180)->nullable();
            $table->json('palestrante_titulo')->nullable();
            $table->string('palestrante_foto')->nullable();

            // Meta
            $table->string('cor_destaque', 10)->default('#a87841');
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->boolean('destaque')->default(false);

            $table->timestamps();

            $table->index('ativo');
            $table->index('data_inicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
