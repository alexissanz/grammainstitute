<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class LanguagesController extends Controller
{
    private array $available = [
        'pt_BR' => ['name' => 'Português (Brasil)', 'flag' => '🇧🇷', 'dir' => 'ltr'],
        'en'    => ['name' => 'English', 'flag' => '🇬🇧', 'dir' => 'ltr'],
        'es'    => ['name' => 'Español', 'flag' => '🇪🇸', 'dir' => 'ltr'],
        'he'    => ['name' => 'עברית', 'flag' => '🇮🇱', 'dir' => 'rtl'],
        'el'    => ['name' => 'Ελληνικά', 'flag' => '🇬🇷', 'dir' => 'ltr'],
    ];

    public function index()
    {
        $settings = SiteSetting::current();
        $active = $settings->idiomas_activos ?? [];
        $languages = $this->available;

        return view('admin.languages', compact('languages', 'active', 'settings'));
    }
}
