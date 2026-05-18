<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = ['ordem', 'tipo', 'imagem', 'video', 'poster', 'titulo', 'subtitulo', 'ativo'];

    protected $casts = [
        'titulo'    => 'array',
        'subtitulo' => 'array',
        'ativo'     => 'boolean',
    ];

    public function isVideo(): bool
    {
        return ($this->tipo === 'video') && !empty($this->video);
    }

    public function mediaUrl(): ?string
    {
        if ($this->isVideo()) {
            return \Illuminate\Support\Facades\Storage::url($this->video);
        }
        if ($this->imagem) {
            return \Illuminate\Support\Facades\Storage::url($this->imagem);
        }
        return null;
    }

    public function posterUrl(): ?string
    {
        if (!empty($this->poster))  return \Illuminate\Support\Facades\Storage::url($this->poster);
        if (!empty($this->imagem))  return \Illuminate\Support\Facades\Storage::url($this->imagem);
        return null;
    }

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
