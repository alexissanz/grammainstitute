<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'slug', 'codigo', 'glifo', 'cor_destaque', 'imagem_capa', 'imagem_fundo',
        'nome', 'subtitulo', 'descricao_curta', 'descricao_longa',
        'historia_lingua', 'alfabeto_info', 'para_quem', 'o_que_aprende', 'niveis',
        'professor_nome', 'professor_foto', 'professor_bio', 'professor_titulos',
        'duracao_total', 'formato', 'preco', 'vagas_por_turma',
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
        return $data[$locale]
            ?? $data['pt_BR']
            ?? $data['en']
            ?? (string) reset($data)
            ?? '';
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
        $value = $data[$locale]
            ?? $data['pt_BR']
            ?? $data['en']
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
        return $this->imagem_capa
            ? (str_starts_with($this->imagem_capa, 'http') ? $this->imagem_capa : \Illuminate\Support\Facades\Storage::url($this->imagem_capa))
            : null;
    }

    public function imagemFundoUrl(): ?string
    {
        return $this->imagem_fundo
            ? (str_starts_with($this->imagem_fundo, 'http') ? $this->imagem_fundo : \Illuminate\Support\Facades\Storage::url($this->imagem_fundo))
            : null;
    }

    public function professorFotoUrl(): ?string
    {
        return $this->professor_foto
            ? (str_starts_with($this->professor_foto, 'http') ? $this->professor_foto : \Illuminate\Support\Facades\Storage::url($this->professor_foto))
            : null;
    }
}
