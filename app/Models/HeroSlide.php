<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = ['ordem', 'imagem', 'titulo', 'subtitulo', 'ativo'];

    protected $casts = [
        'titulo'    => 'array',
        'subtitulo' => 'array',
        'ativo'     => 'boolean',
    ];

    public function getTitulo(string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->titulo ?? [];
        return $data[$locale] ?? $data['pt_BR'] ?? '';
    }

    public function getSubtitulo(string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->subtitulo ?? [];
        return $data[$locale] ?? $data['pt_BR'] ?? '';
    }
}
