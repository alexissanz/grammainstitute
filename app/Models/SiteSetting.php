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
        'logo', 'logo_rodape', 'favicon', 'imagem_hero', 'hero_tipo', 'hero_video',
        'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok', 'google_url', 'wikipedia_url', 'loja_url',
        'idioma_padrao', 'idiomas_activos', 'texto_rodape',
        'font_body_family', 'font_display_family', 'font_menu_family',
        'font_course_family', 'font_footer_family',
        'font_body_size', 'font_menu_size', 'font_course_size',
        'font_title_size', 'font_footer_size',
        'font_hero_intro_size', 'font_hero_slide_size',
        'footer_padding_top', 'footer_padding_bottom',
        'footer_email_size', 'footer_credit_size',
        'footer_copyright_size', 'footer_tagline_size',
        'meta_title', 'meta_description',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
        'smtp_encryption', 'smtp_from_address', 'smtp_from_name',
    ];

    protected $casts = [
        'idiomas_activos' => 'array',
        'whatsapp_ativo'  => 'boolean',
        'font_body_size' => 'integer',
        'font_menu_size' => 'integer',
        'font_course_size' => 'integer',
        'font_title_size' => 'integer',
        'font_footer_size' => 'integer',
        'font_hero_intro_size' => 'integer',
        'font_hero_slide_size' => 'integer',
        'footer_padding_top' => 'integer',
        'footer_padding_bottom' => 'integer',
        'footer_email_size' => 'integer',
        'footer_credit_size' => 'integer',
        'footer_copyright_size' => 'integer',
        'footer_tagline_size' => 'integer',
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
            'idioma_padrao'  => 'en',
            'idiomas_activos' => ['en', 'pt_BR', 'es'],
            'font_body_family' => 'didot',
            'font_display_family' => 'bodoni',
            'font_menu_family' => 'didot',
            'font_course_family' => 'cinzel',
            'font_footer_family' => 'didot',
            'font_body_size' => 18,
            'font_menu_size' => 14,
            'font_course_size' => 22,
            'font_title_size' => 38,
            'font_footer_size' => 16,
            'font_hero_intro_size' => 70,
            'font_hero_slide_size' => 64,
            'smtp_encryption' => 'tls',
            'facebook' => 'https://facebook.com/grammainstitute',
            'instagram' => 'https://instagram.com/grammainstitute',
            'linkedin' => 'https://linkedin.com/company/grammainstitute',
            'youtube' => 'https://youtube.com/@grammainstitute',
            'tiktok' => 'https://tiktok.com/@grammainstitute',
            'google_url' => 'https://www.google.com/search?q=Gramma+Institute',
            'wikipedia_url' => 'https://en.wikipedia.org/wiki/Gramma_Institute',
        ]);
    }

    public static function typographyFontOptions(): array
    {
        return [
            'didot' => 'Didot / GFS Didot',
            'bodoni' => 'Bodoni Moda',
            'cinzel' => 'Cinzel',
            'cormorant' => 'Cormorant Garamond',
            'inter' => 'Inter',
            'noto' => 'Noto Serif',
        ];
    }
}
