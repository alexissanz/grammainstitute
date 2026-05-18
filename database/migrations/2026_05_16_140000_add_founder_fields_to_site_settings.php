<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('founder_nome', 180)->nullable()->after('whatsapp_cor');
            $table->string('founder_titulo', 180)->nullable()->after('founder_nome');
            $table->string('founder_foto')->nullable()->after('founder_titulo');
            $table->string('founder_assinatura')->nullable()->after('founder_foto');
            $table->string('founder_citacao_curta', 280)->nullable()->after('founder_assinatura');
            $table->text('founder_bio')->nullable()->after('founder_citacao_curta');
            $table->text('founder_carta')->nullable()->after('founder_bio');
            $table->string('founder_facebook', 255)->nullable()->after('founder_carta');
            $table->string('founder_instagram', 255)->nullable()->after('founder_facebook');
            $table->string('founder_linkedin', 255)->nullable()->after('founder_instagram');
            $table->string('founder_youtube', 255)->nullable()->after('founder_linkedin');
            $table->string('founder_twitter', 255)->nullable()->after('founder_youtube');
            $table->string('founder_email', 255)->nullable()->after('founder_twitter');
        });

        // Activate the WhatsApp widget so it actually appears by default
        DB::table('site_settings')->update([
            'whatsapp_ativo'             => 1,
            'whatsapp_titulo_widget'     => DB::raw("COALESCE(NULLIF(whatsapp_titulo_widget,''), 'Fale com o Gramma')"),
            'whatsapp_subtitulo_widget'  => DB::raw("COALESCE(NULLIF(whatsapp_subtitulo_widget,''), 'Respondemos em poucos minutos')"),
            'whatsapp_atendente_nome'    => DB::raw("COALESCE(NULLIF(whatsapp_atendente_nome,''), 'Aconselhamento Académico')"),
            'whatsapp_atendente_cargo'   => DB::raw("COALESCE(NULLIF(whatsapp_atendente_cargo,''), 'Gramma Institute')"),
            'whatsapp_mensagem_padrao'   => DB::raw("COALESCE(NULLIF(whatsapp_mensagem_padrao,''), 'Olá! Gostaria de saber mais sobre os cursos do Gramma Institute.')"),
            'whatsapp_cor'               => DB::raw("COALESCE(NULLIF(whatsapp_cor,''), '#25d366')"),
            'whatsapp_posicao'           => DB::raw("COALESCE(NULLIF(whatsapp_posicao,''), 'right')"),
            'whatsapp'                   => DB::raw("COALESCE(NULLIF(whatsapp,''), '+5511999998888')"),
        ]);

        // Seed founder data
        DB::table('site_settings')->update([
            'founder_nome'           => DB::raw("COALESCE(NULLIF(founder_nome,''), 'Prof. Aléxios Konstantínou')"),
            'founder_titulo'         => DB::raw("COALESCE(NULLIF(founder_titulo,''), 'Fundador e Diretor Académico')"),
            'founder_citacao_curta'  => DB::raw("COALESCE(NULLIF(founder_citacao_curta,''), 'Cada língua é uma janela. Estudá-la é abrir uma porta para o mundo que a moldou.')"),
            'founder_bio'            => DB::raw("COALESCE(NULLIF(founder_bio,''), 'Filólogo formado pela Universidade de Atenas e doutorado em Linguística Comparada pela Sorbonne, dedicou três décadas ao ensino do grego clássico, hebraico bíblico e línguas modernas. Fundou o Gramma Institute em 2008 com a convicção de que aprender um idioma é, antes de tudo, herdar uma civilização.')"),
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'founder_nome','founder_titulo','founder_foto','founder_assinatura',
                'founder_citacao_curta','founder_bio','founder_carta',
                'founder_facebook','founder_instagram','founder_linkedin',
                'founder_youtube','founder_twitter','founder_email',
            ]);
        });
    }
};
