<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'nome_site', 'titulo_site', 'subtitulo_site', 'descricao_site',
        'email_institucional', 'telefone', 'whatsapp', 'endereco', 'cidade', 'pais',
        'logo', 'favicon', 'imagem_hero',
        'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'idioma_padrao', 'idiomas_activos', 'texto_rodape',
        'meta_title', 'meta_description',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
        'smtp_encryption', 'smtp_from_address', 'smtp_from_name',
    ];

    protected $casts = [
        'idiomas_activos' => 'array',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'nome_site'      => 'Gramma Institute',
            'titulo_site'    => 'Gramma Institute',
            'idioma_padrao'  => 'pt_BR',
            'idiomas_activos' => ['pt_BR', 'en', 'es', 'he', 'el'],
            'smtp_encryption' => 'tls',
        ]);
    }
}
