<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('codigo', 20)->nullable();           // pt_BR, en, es, he, el ...
            $table->string('glifo', 20)->nullable();            // Ελ, אב, En ...
            $table->string('cor_destaque', 10)->default('#a87841');
            $table->string('imagem_capa')->nullable();
            $table->string('imagem_fundo')->nullable();         // hero banner

            // Translatable JSON content
            $table->json('nome');                                // {pt_BR: "...", en: "..."}
            $table->json('subtitulo')->nullable();
            $table->json('descricao_curta')->nullable();
            $table->json('descricao_longa')->nullable();
            $table->json('historia_lingua')->nullable();
            $table->json('alfabeto_info')->nullable();
            $table->json('para_quem')->nullable();
            $table->json('o_que_aprende')->nullable();           // bullets json: {pt_BR:[...], en:[...]}
            $table->json('niveis')->nullable();                  // [{nome:{pt_BR:"A1"}, descricao:{...}, duracao:"30h"}]

            // Professor
            $table->string('professor_nome')->nullable();
            $table->string('professor_foto')->nullable();
            $table->json('professor_bio')->nullable();
            $table->json('professor_titulos')->nullable();       // pt_BR:"PhD em..." en:"..."

            // Logistics
            $table->string('duracao_total', 100)->nullable();
            $table->string('formato', 100)->nullable();          // online / presencial / híbrido
            $table->string('preco', 100)->nullable();
            $table->integer('vagas_por_turma')->nullable();

            // Contact
            $table->string('contato_whatsapp', 30)->nullable();
            $table->string('contato_email', 255)->nullable();
            $table->string('contato_telefone', 30)->nullable();

            // Meta / Listing
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->boolean('destaque')->default(false);
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();

            $table->timestamps();

            $table->index('ativo');
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
