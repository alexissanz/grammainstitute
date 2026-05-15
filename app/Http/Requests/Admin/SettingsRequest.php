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
            'endereco'            => ['nullable', 'string', 'max:255'],
            'cidade'              => ['nullable', 'string', 'max:100'],
            'pais'                => ['nullable', 'string', 'max:100'],
            'logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'favicon'             => ['nullable', 'file', 'mimes:ico,png', 'max:512'],
            'imagem_hero'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'facebook'            => ['nullable', 'url', 'max:255'],
            'instagram'           => ['nullable', 'url', 'max:255'],
            'linkedin'            => ['nullable', 'url', 'max:255'],
            'youtube'             => ['nullable', 'url', 'max:255'],
            'tiktok'              => ['nullable', 'url', 'max:255'],
            'idioma_padrao'       => ['nullable', 'string', 'in:pt_BR,en,es,he,el'],
            'idiomas_activos'     => ['nullable', 'array'],
            'idiomas_activos.*'   => ['string', 'in:pt_BR,en,es,he,el'],
            'texto_rodape'        => ['nullable', 'string'],
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
