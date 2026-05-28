<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlossaryTerm extends Model
{
    protected $fillable = [
        'slug', 'letra', 'termo', 'transliteracao', 'lingua', 'categoria',
        'significado', 'descricao', 'etimologia', 'exemplo_uso',
        'citacao_classica', 'citacao_autor',
        'imagem', 'ordem', 'destaque', 'ativo',
    ];

    protected $casts = [
        'significado'      => 'array',
        'descricao'        => 'array',
        'etimologia'       => 'array',
        'exemplo_uso'      => 'array',
        'citacao_classica' => 'array',
        'citacao_autor'    => 'array',
        'destaque'         => 'boolean',
        'ativo'            => 'boolean',
    ];

    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->{$field} ?? [];
        if (! is_array($data)) {
            return (string) $data;
        }
        return $data[$locale]
            ?? $data['pt_BR']
            ?? $data['en']
            ?? (string) reset($data)
            ?? '';
    }

    public function imagemUrl(): ?string
    {
        return $this->imagem
            ? (str_starts_with($this->imagem, 'http') ? $this->imagem : route('media.serve', ['path' => $this->imagem], false))
            : null;
    }

    public function letterKey(): string
    {
        $key = trim((string) ($this->letra ?: $this->termo));

        return $key !== '' ? strtoupper($key) : '#';
    }

    public static function linguaLabel(string $code): string
    {
        return match ($code) {
            'el'   => 'Ἑλληνική',
            'he'   => 'עִבְרִית',
            'la'   => 'Latine',
            'en'   => 'English',
            'es'   => 'Español',
            'pt'   => 'Português',
            default => strtoupper($code),
        };
    }
}
