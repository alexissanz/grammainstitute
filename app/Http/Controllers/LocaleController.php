<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    private array $allowed = ['pt_BR', 'en', 'es', 'he', 'el'];

    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, $this->allowed)) {
            $locale = 'pt_BR';
        }

        session(['locale' => $locale]);

        return redirect()->back()->withInput();
    }
}
