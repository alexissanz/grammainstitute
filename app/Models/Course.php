<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Course extends Model
{
    protected const DEFAULT_IMAGES = [
        'grego' => [
            'cover' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1555993539-1732b0258235?auto=format&fit=crop&w=2400&q=85',
        ],
        'hebraico' => [
            'cover' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=2400&q=85',
        ],
        'hebraico-biblico-moderno' => [
            'cover' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=2400&q=85',
        ],
        'latim' => [
            'cover' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Colosseo_2020.jpg',
            'background' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Colosseo_2020.jpg',
        ],
        'linguistica-descritiva' => [
            'cover' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=2400&q=85',
        ],
        'linguistica' => [
            'cover' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=2400&q=85',
        ],
        'ingles' => [
            'cover' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1486299267070-83823f5448dd?auto=format&fit=crop&w=2400&q=85',
        ],
        'espanhol' => [
            'cover' => 'https://images.unsplash.com/photo-1515444744559-5f3205c7e4c5?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325?auto=format&fit=crop&w=2400&q=85',
        ],
        'portugues' => [
            'cover' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
            'background' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
        ],
        'portugues-para-estrangeiros-ple' => [
            'cover' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
            'background' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
        ],
        'portuguese-for-foreigners-pfl' => [
            'cover' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
            'background' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Cristo_Redentor_-_Rio_de_Janeiro%2C_Brasil.jpg',
        ],
        'grego-biblico' => [
            'cover' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=1600&q=85',
            'background' => 'https://images.unsplash.com/photo-1555993539-1732b0258235?auto=format&fit=crop&w=2400&q=85',
        ],
    ];
    protected $fillable = [
        'slug', 'codigo', 'glifo', 'cor_destaque', 'imagem_capa', 'imagem_fundo',
        'nome', 'subtitulo', 'descricao_curta', 'descricao_longa',
        'historia_lingua', 'alfabeto_info', 'para_quem', 'o_que_aprende', 'niveis',
        'professor_nome', 'professor_foto', 'professor_bio', 'professor_titulos',
        'duracao_total', 'formato', 'preco', 'vagas_por_turma', 'material_gratis', 'material_gratis_texto', 'certificacao_gratis', 'certificacao_gratis_texto',
        'contato_whatsapp', 'contato_email', 'contato_telefone',
        'ordem', 'ativo', 'destaque', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'nome'              => 'array',
        'subtitulo'         => 'array',
        'descricao_curta'   => 'array',
        'descricao_longa'   => 'array',
        'historia_lingua'   => 'array',
        'alfabeto_info'     => 'array',
        'para_quem'         => 'array',
        'o_que_aprende'     => 'array',
        'niveis'            => 'array',
        'professor_bio'     => 'array',
        'professor_titulos' => 'array',
        'meta_title'        => 'array',
        'meta_description'  => 'array',
        'material_gratis'   => 'boolean',
        'certificacao_gratis' => 'boolean',
        'ativo'             => 'boolean',
        'destaque'          => 'boolean',
    ];

    /**
     * Read a translated JSON column with locale fallback chain.
     */
    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->{$field} ?? [];
        if (! is_array($data)) {
            return (string) $data;
        }
        $defaultLocale = SiteSetting::query()->value('idioma_padrao') ?: 'en';

        foreach ([$locale, $defaultLocale, 'en', 'pt_BR'] as $candidate) {
            $value = Arr::get($data, $candidate);
            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return (string) (reset($data) ?: '');
    }

    /**
     * Same but for fields that hold arrays inside the JSON (bullet lists).
     */
    public function tArray(string $field, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $data = $this->{$field} ?? [];
        if (! is_array($data)) {
            return [];
        }
        $defaultLocale = SiteSetting::query()->value('idioma_padrao') ?: 'en';
        $value = $data[$locale]
            ?? $data[$defaultLocale]
            ?? $data['en']
            ?? $data['pt_BR']
            ?? reset($data);

        return is_array($value) ? $value : [];
    }

    /**
     * Build a WhatsApp link using either the course-specific number or fall back to the site setting.
     */
    public function whatsappLink(): ?string
    {
        $number = $this->contato_whatsapp ?: optional(SiteSetting::current())->whatsapp;
        if (! $number) return null;

        $digits = preg_replace('/\D+/', '', $number);
        if (! $digits) return null;

        $msg = 'Olá! Tenho interesse no curso de ' . $this->t('nome') . '.';
        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($msg);
    }

    public function imagemCapaUrl(): ?string
    {
        if ($this->imagem_capa) {
            return str_starts_with($this->imagem_capa, 'http')
                ? $this->imagem_capa
                : route('media.serve', ['path' => $this->imagem_capa], false);
        }

        return $this->fallbackImageUrl('cover');
    }

    public function imagemFundoUrl(): ?string
    {
        if ($this->imagem_fundo) {
            return str_starts_with($this->imagem_fundo, 'http')
                ? $this->imagem_fundo
                : route('media.serve', ['path' => $this->imagem_fundo], false);
        }

        return $this->fallbackImageUrl('background');
    }

    public function professorFotoUrl(): ?string
    {
        return $this->professor_foto
            ? (str_starts_with($this->professor_foto, 'http') ? $this->professor_foto : route('media.serve', ['path' => $this->professor_foto], false))
            : null;
    }

    protected function fallbackImageUrl(string $kind): ?string
    {
        $candidates = [];

        if ($this->slug) {
            $candidates[] = \Illuminate\Support\Str::slug($this->slug);
        }

        foreach ((array) ($this->nome ?? []) as $name) {
            if (!is_string($name) || trim($name) === '') {
                continue;
            }
            $candidates[] = \Illuminate\Support\Str::slug($name);
        }

        $fallbackName = $this->t('nome');
        if ($fallbackName !== '') {
            $candidates[] = \Illuminate\Support\Str::slug($fallbackName);
        }

        foreach (self::DEFAULT_IMAGES as $slug => $images) {
            foreach ($candidates as $candidate) {
                if ($candidate === $slug || str_contains($candidate, $slug)) {
                    return $images[$kind] ?? null;
                }
            }
        }

        return null;
    }
}
