<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
        if ($this->isVideo() && $this->video) return route('media.serve', ['path' => $this->video], false);
        if ($this->imagem)                    return route('media.serve', ['path' => $this->imagem], false);
        return null;
    }

    public function posterUrl(): ?string
    {
        if (!empty($this->poster))  return route('media.serve', ['path' => $this->poster], false);
        if (!empty($this->imagem))  return route('media.serve', ['path' => $this->imagem], false);
        return null;
    }

    public function mediaMimeType(): string
    {
        $path = (string) $this->video;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            'm4v' => 'video/x-m4v',
            default => 'video/mp4',
        };
    }

    public function getTitulo(string $locale = null): string
    {
        return $this->translatedValue('titulo', $locale);
    }

    public function getSubtitulo(string $locale = null): string
    {
        return $this->translatedValue('subtitulo', $locale);
    }

    private function translatedValue(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = SiteSetting::query()->value('idioma_padrao') ?: 'pt_BR';
        $data = $this->{$field} ?? [];

        if (!is_array($data) || $data === []) {
            return '';
        }

        foreach ([$locale, $defaultLocale, 'pt_BR', 'en'] as $candidate) {
            $value = Arr::get($data, $candidate);
            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        foreach ($data as $value) {
            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return '';
    }
}
