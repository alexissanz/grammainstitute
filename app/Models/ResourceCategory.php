<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResourceCategory extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'icon', 'ordem', 'ativo'];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'ativo'       => 'boolean',
        'ordem'       => 'integer',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(ResourceLink::class, 'category_id')
            ->orderBy('grupo_ordem')
            ->orderBy('ordem');
    }

    public function activeLinks(): HasMany
    {
        return $this->links()->where('ativo', true);
    }

    /** Locale-aware accessor: returns the title or description in the current locale. */
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
