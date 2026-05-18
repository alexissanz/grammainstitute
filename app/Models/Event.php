<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'slug', 'imagem', 'titulo', 'subtitulo', 'descricao',
        'local_nome', 'data_inicio', 'data_fim', 'timezone',
        'local_endereco', 'local_cidade', 'formato', 'link_online',
        'gratuito', 'preco', 'preco_valor', 'moeda',
        'link_inscricao', 'vagas_total', 'vagas_ocupadas',
        'palestrante_nome', 'palestrante_titulo', 'palestrante_foto',
        'cor_destaque', 'ordem', 'ativo', 'destaque',
    ];

    protected $casts = [
        'titulo'             => 'array',
        'subtitulo'          => 'array',
        'descricao'          => 'array',
        'local_nome'         => 'array',
        'palestrante_titulo' => 'array',
        'data_inicio'        => 'datetime',
        'data_fim'           => 'datetime',
        'preco_valor'        => 'decimal:2',
        'gratuito'           => 'boolean',
        'ativo'              => 'boolean',
        'destaque'           => 'boolean',
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

    public function palestranteFotoUrl(): ?string
    {
        return $this->palestrante_foto
            ? (str_starts_with($this->palestrante_foto, 'http') ? $this->palestrante_foto : Storage::url($this->palestrante_foto))
            : null;
    }

    public function isFuturo(): bool
    {
        return $this->data_inicio && $this->data_inicio->isFuture();
    }

    public function isOngoing(): bool
    {
        $now = now();
        return $this->data_inicio && $this->data_inicio->lte($now)
            && (! $this->data_fim || $this->data_fim->gte($now));
    }

    public function isPassado(): bool
    {
        return $this->data_fim
            ? $this->data_fim->isPast()
            : ($this->data_inicio && $this->data_inicio->isPast());
    }

    public function statusLabel(): string
    {
        if ($this->isOngoing()) return 'A decorrer';
        if ($this->isPassado()) return 'Concluído';
        return 'Brevemente';
    }

    public function precoFormatado(): string
    {
        if ($this->gratuito) return 'Gratuito';
        return $this->preco ?: ($this->moeda . ' ' . number_format((float) $this->preco_valor, 2, ',', '.'));
    }
}
