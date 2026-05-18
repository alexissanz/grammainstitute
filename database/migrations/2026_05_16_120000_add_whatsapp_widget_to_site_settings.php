<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('whatsapp_ativo')->default(false)->after('whatsapp');
            $table->string('whatsapp_mensagem_padrao', 500)->nullable()->after('whatsapp_ativo');
            $table->string('whatsapp_titulo_widget', 120)->nullable()->after('whatsapp_mensagem_padrao');
            $table->string('whatsapp_subtitulo_widget', 200)->nullable()->after('whatsapp_titulo_widget');
            $table->string('whatsapp_atendente_nome', 120)->nullable()->after('whatsapp_subtitulo_widget');
            $table->string('whatsapp_atendente_cargo', 120)->nullable()->after('whatsapp_atendente_nome');
            $table->string('whatsapp_posicao', 10)->default('right')->after('whatsapp_atendente_cargo');
            $table->string('whatsapp_cor', 10)->default('#25d366')->after('whatsapp_posicao');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_ativo',
                'whatsapp_mensagem_padrao',
                'whatsapp_titulo_widget',
                'whatsapp_subtitulo_widget',
                'whatsapp_atendente_nome',
                'whatsapp_atendente_cargo',
                'whatsapp_posicao',
                'whatsapp_cor',
            ]);
        });
    }
};
