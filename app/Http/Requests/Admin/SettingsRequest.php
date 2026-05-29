<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nome_site'           => ['nullable', 'string', 'max:255'],
            'titulo_site'         => ['nullable', 'string', 'max:255'],
            'subtitulo_site'      => ['nullable', 'string', 'max:255'],
            'descricao_site'      => ['nullable', 'string'],
            'email_institucional' => ['nullable', 'email', 'max:255'],
            'telefone'            => ['nullable', 'string', 'max:30'],
            'whatsapp'            => ['nullable', 'string', 'max:30'],
            'whatsapp_ativo'              => ['nullable', 'boolean'],
            'whatsapp_mensagem_padrao'    => ['nullable', 'string', 'max:500'],
            'whatsapp_titulo_widget'      => ['nullable', 'string', 'max:120'],
            'whatsapp_subtitulo_widget'   => ['nullable', 'string', 'max:200'],
            'whatsapp_atendente_nome'     => ['nullable', 'string', 'max:120'],
            'whatsapp_atendente_cargo'    => ['nullable', 'string', 'max:120'],
            'whatsapp_posicao'            => ['nullable', 'string', 'in:left,right'],
            'whatsapp_cor'                => ['nullable', 'string', 'max:10'],

            // Founder
            'founder_nome'           => ['nullable', 'string', 'max:180'],
            'founder_titulo'         => ['nullable', 'string', 'max:180'],
            'founder_foto'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'founder_assinatura'     => ['nullable', 'image', 'mimes:png,svg,webp', 'max:2048'],
            'founder_citacao_curta'  => ['nullable', 'string', 'max:280'],
            'founder_bio'            => ['nullable', 'string'],
            'founder_carta'          => ['nullable', 'string'],
            'founder_facebook'       => ['nullable', 'url', 'max:255'],
            'founder_instagram'      => ['nullable', 'url', 'max:255'],
            'founder_linkedin'       => ['nullable', 'url', 'max:255'],
            'founder_youtube'        => ['nullable', 'url', 'max:255'],
            'founder_twitter'        => ['nullable', 'url', 'max:255'],
            'founder_email'          => ['nullable', 'email', 'max:255'],
            'endereco'            => ['nullable', 'string', 'max:255'],
            'cidade'              => ['nullable', 'string', 'max:100'],
            'pais'                => ['nullable', 'string', 'max:100'],
            // NOTE: we use 'file' (not 'image') because Laravel's 'image' rule
            // rejects SVG by default and was returning "validation.mimes".
            'logo'                => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,webp,gif', 'max:4096'],
            'logo_rodape'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,webp,gif', 'max:4096'],
            'favicon'             => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp,svg', 'max:1024'],
            'imagem_hero'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'hero_tipo'           => ['nullable', 'string', 'in:imagem,slides,video'],
            'hero_video'          => ['nullable', 'file', 'mimes:mp4,webm,ogg', 'max:51200'],
            'facebook'            => ['nullable', 'url', 'max:255'],
            'instagram'           => ['nullable', 'url', 'max:255'],
            'linkedin'            => ['nullable', 'url', 'max:255'],
            'youtube'             => ['nullable', 'url', 'max:255'],
            'tiktok'              => ['nullable', 'url', 'max:255'],
            'google_url'          => ['nullable', 'url', 'max:255'],
            'wikipedia_url'       => ['nullable', 'url', 'max:255'],
            'loja_url'            => ['nullable', 'string', 'max:500'],
            'idioma_padrao'       => ['nullable', 'string', 'max:10'],
            'idiomas_activos'     => ['nullable', 'array'],
            'idiomas_activos.*'   => ['string', 'max:10'],
            'texto_rodape'        => ['nullable', 'array'],
            'texto_rodape.*'      => ['nullable', 'string', 'max:500'],
            'font_body_family'    => ['nullable', 'string', 'in:didot,bodoni,cinzel,cormorant,inter,noto'],
            'font_display_family' => ['nullable', 'string', 'in:didot,bodoni,cinzel,cormorant,inter,noto'],
            'font_menu_family'    => ['nullable', 'string', 'in:didot,bodoni,cinzel,cormorant,inter,noto'],
            'font_course_family'  => ['nullable', 'string', 'in:didot,bodoni,cinzel,cormorant,inter,noto'],
            'font_footer_family'  => ['nullable', 'string', 'in:didot,bodoni,cinzel,cormorant,inter,noto'],
            'font_body_size'      => ['nullable', 'integer', 'min:14', 'max:24'],
            'font_menu_size'      => ['nullable', 'integer', 'min:12', 'max:28'],
            'font_course_size'    => ['nullable', 'integer', 'min:16', 'max:48'],
            'font_title_size'     => ['nullable', 'integer', 'min:24', 'max:72'],
            'font_footer_size'    => ['nullable', 'integer', 'min:12', 'max:24'],
            'font_hero_intro_size'=> ['nullable', 'integer', 'min:28', 'max:120'],
            'font_hero_slide_size'=> ['nullable', 'integer', 'min:24', 'max:120'],
            'footer_padding_top'    => ['nullable', 'integer', 'min:0', 'max:200'],
            'footer_padding_bottom' => ['nullable', 'integer', 'min:0', 'max:200'],
            'footer_email_size'     => ['nullable', 'integer', 'min:10', 'max:40'],
            'footer_credit_size'    => ['nullable', 'integer', 'min:10', 'max:40'],
            'footer_copyright_size' => ['nullable', 'integer', 'min:10', 'max:40'],
            'footer_tagline_size'   => ['nullable', 'integer', 'min:8',  'max:40'],
            'footer_tagline_text'   => ['nullable', 'array'],
            'footer_tagline_text.*' => ['nullable', 'string', 'max:255'],
            'footer_credit_text'    => ['nullable', 'array'],
            'footer_credit_text.*'  => ['nullable', 'string', 'max:255'],
            'footer_credit_url'     => ['nullable', 'string', 'max:500'],
            'meta_title'          => ['nullable', 'string', 'max:160'],
            'meta_description'    => ['nullable', 'string', 'max:320'],
            'smtp_host'           => ['nullable', 'string', 'max:255'],
            'smtp_port'           => ['nullable', 'integer', 'min:1', 'max:65535'],
            'smtp_username'       => ['nullable', 'string', 'max:255'],
            'smtp_password'       => ['nullable', 'string', 'max:255'],
            'smtp_encryption'     => ['nullable', 'string', 'in:tls,ssl,starttls'],
            'smtp_from_address'   => ['nullable', 'email', 'max:255'],
            'smtp_from_name'      => ['nullable', 'string', 'max:255'],
        ];
    }
}
