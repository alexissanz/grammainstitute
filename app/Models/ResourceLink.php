<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceLink extends Model
{
    protected $fillable = ['category_id', 'grupo', 'grupo_ordem', 'title', 'description', 'url', 'ordem', 'ativo'];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'ativo'       => 'boolean',
        'ordem'       => 'integer',
        'grupo_ordem' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }

    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $val    = $this->{$field};
        if (!is_array($val)) return (string) ($val ?? '');
        foreach ([$locale, 'pt_BR', 'en'] as $loc) {
            if (!empty($val[$loc])) return (string) $val[$loc];
        }
        return '';
    }
}
