<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'about_page';

    protected $fillable = [
        'quote_text', 'quote_author', 'foto', 'foto_bw',
        'founder_title', 'founder_text',
        'institute_title', 'institute_text',
        'mission_title', 'mission_text',
        'expertise_title', 'expertise_items',
        'closing_title', 'closing_text',
    ];

    protected $casts = [
        'quote_text'      => 'array',
        'founder_title'   => 'array',
        'founder_text'    => 'array',
        'institute_title' => 'array',
        'institute_text'  => 'array',
        'mission_title'   => 'array',
        'mission_text'    => 'array',
        'expertise_title' => 'array',
        'expertise_items' => 'array',
        'closing_title'   => 'array',
        'closing_text'    => 'array',
        'foto_bw'         => 'boolean',
    ];

    /** Singleton: always the first row (create it on first access). */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /** Public URL for the "Who is" portrait, served via the /media route. */
    public function fotoUrl(): ?string
    {
        return $this->foto ? url('media/' . $this->foto) : null;
    }

    /** Localised getter — tries the current locale, falls back to pt_BR / en. */
    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $value  = $this->{$field};

        if (!is_array($value)) {
            return (string) ($value ?? '');
        }

        foreach ([$locale, 'pt_BR', 'en'] as $loc) {
            if (!empty($value[$loc])) {
                return (string) $value[$loc];
            }
        }
        return '';
    }

    /** Areas of expertise as a plain array of strings in the current locale. */
    public function expertiseList(?string $locale = null): array
    {
        $locale = $locale ?: app()->getLocale();
        $items  = $this->expertise_items ?? [];
        $out    = [];
        foreach ($items as $item) {
            if (is_string($item)) { $out[] = $item; continue; }
            if (!is_array($item)) continue;
            foreach ([$locale, 'pt_BR', 'en'] as $loc) {
                if (!empty($item[$loc])) { $out[] = $item[$loc]; break; }
            }
        }
        return $out;
    }
}
