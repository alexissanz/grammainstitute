<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    protected $fillable = [
        'slug', 'imagem',
        'titulo', 'subtitulo', 'descricao', 'badge_texto', 'cta_texto',
        'cor_fundo', 'cor_texto', 'cor_destaque',
        'cta_url', 'codigo_promo', 'desconto',
        'inicio', 'fim',
        'mostrar_topbar', 'mostrar_home', 'mostrar_popup',
        'ordem', 'ativo',
    ];

    protected $casts = [
        'titulo'         => 'array',
        'subtitulo'      => 'array',
        'descricao'      => 'array',
        'badge_texto'    => 'array',
        'cta_texto'      => 'array',
        'inicio'         => 'datetime',
        'fim'            => 'datetime',
        'mostrar_topbar' => 'boolean',
        'mostrar_home'   => 'boolean',
        'mostrar_popup'  => 'boolean',
        'ativo'          => 'boolean',
    ];

    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->{$field} ?? [];
        if (! is_array($data)) return (string) $data;
        return $data[$locale] ?? $data['pt_BR'] ?? $data['en'] ?? (string) (reset($data) ?: '');
    }

    public function imagemUrl(): ?string
    {
        return $this->imagem
            ? (str_starts_with($this->imagem, 'http') ? $this->imagem : Storage::url($this->imagem))
            : null;
    }

    public function isCurrent(): bool
    {
        if (! $this->ativo) return false;
        $now = now();
        if ($this->inicio && $this->inicio->gt($now)) return false;
        if ($this->fim && $this->fim->lt($now)) return false;
        return true;
    }

    public static function activeForTopbar()
    {
        return static::where('ativo', true)->where('mostrar_topbar', true)->orderBy('ordem')->get()
            ->filter(fn ($p) => $p->isCurrent())->values();
    }

    public static function activeForHome()
    {
        return static::where('ativo', true)->where('mostrar_home', true)->orderBy('ordem')->get()
            ->filter(fn ($p) => $p->isCurrent())->values();
    }
}
