<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'nome_site', 'titulo_site', 'subtitulo_site', 'descricao_site',
        'email_institucional', 'telefone', 'whatsapp', 'endereco', 'cidade', 'pais',
        'whatsapp_ativo', 'whatsapp_mensagem_padrao', 'whatsapp_titulo_widget',
        'whatsapp_subtitulo_widget', 'whatsapp_atendente_nome', 'whatsapp_atendente_cargo',
        'whatsapp_posicao', 'whatsapp_cor',
        'founder_nome', 'founder_titulo', 'founder_foto', 'founder_assinatura',
        'founder_citacao_curta', 'founder_bio', 'founder_carta',
        'founder_facebook', 'founder_instagram', 'founder_linkedin',
        'founder_youtube', 'founder_twitter', 'founder_email',
        'logo', 'favicon', 'imagem_hero', 'hero_tipo', 'hero_video',
        'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'idioma_padrao', 'idiomas_activos', 'texto_rodape',
        'meta_title', 'meta_description',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
        'smtp_encryption', 'smtp_from_address', 'smtp_from_name',
    ];

    protected $casts = [
        'idiomas_activos' => 'array',
        'whatsapp_ativo'  => 'boolean',
    ];

    /**
     * Format WhatsApp number for wa.me link (digits only).
     */
    public function whatsappLink(): ?string
    {
        if (! $this->whatsapp_ativo || ! $this->whatsapp) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $this->whatsapp);
        if (! $digits) {
            return null;
        }

        $msg = $this->whatsapp_mensagem_padrao
            ?: 'Olá! Gostaria de saber mais sobre os cursos do Gramma Institute.';

        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($msg);
    }

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'nome_site'      => 'Gramma Institute',
            'titulo_site'    => 'Gramma Institute',
            'idioma_padrao'  => 'pt_BR',
            'idiomas_activos' => ['pt_BR', 'en', 'es', 'he', 'el', 'la'],
            'smtp_encryption' => 'tls',
        ]);
    }
}
