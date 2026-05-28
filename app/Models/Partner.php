<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['nome', 'foto', 'link', 'ordem', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    public function fotoUrl(): ?string
    {
        return $this->foto ? url('media/' . $this->foto) : null;
    }
}
