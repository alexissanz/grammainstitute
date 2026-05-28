<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about    = AboutPage::current();
        $settings = SiteSetting::current();

        $allLangs = [
            'pt_BR' => ['flag' => '🇧🇷', 'name' => 'Português (BR)'],
            'en'    => ['flag' => '🇬🇧', 'name' => 'English'],
            'es'    => ['flag' => '🇪🇸', 'name' => 'Español'],
            'he'    => ['flag' => '🇮🇱', 'name' => 'עברית'],
            'el'    => ['flag' => '🇬🇷', 'name' => 'Ελληνικά'],
            'la'    => ['flag' => '🏛',   'name' => 'Latīna'],
        ];
        $activeCodes = $settings->idiomas_activos ?? array_keys($allLangs);
        $languages   = array_intersect_key($allLangs, array_flip($activeCodes)) ?: $allLangs;

        return view('admin.about.edit', compact('about', 'languages'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'quote_text'       => ['array'],
            'quote_text.*'     => ['nullable', 'string', 'max:1000'],
            'quote_author'     => ['nullable', 'string', 'max:160'],
            'foto'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'founder_title'    => ['array'],
            'founder_title.*'  => ['nullable', 'string', 'max:255'],
            'founder_text'     => ['array'],
            'founder_text.*'   => ['nullable', 'string', 'max:8000'],
            'institute_title'  => ['array'],
            'institute_title.*'=> ['nullable', 'string', 'max:255'],
            'institute_text'   => ['array'],
            'institute_text.*' => ['nullable', 'string', 'max:8000'],
            'mission_title'    => ['array'],
            'mission_title.*'  => ['nullable', 'string', 'max:255'],
            'mission_text'     => ['array'],
            'mission_text.*'   => ['nullable', 'string', 'max:4000'],
            'expertise_title'  => ['array'],
            'expertise_title.*'=> ['nullable', 'string', 'max:255'],
            'expertise_items'  => ['array'],
            'expertise_items.*'=> ['array'],
            'closing_title'    => ['array'],
            'closing_title.*'  => ['nullable', 'string', 'max:255'],
            'closing_text'     => ['array'],
            'closing_text.*'   => ['nullable', 'string', 'max:4000'],
        ]);

        // Clean empty expertise rows: keep only rows that have at least one locale filled.
        $items = collect($data['expertise_items'] ?? [])
            ->map(fn ($row) => is_array($row) ? array_map(fn ($v) => trim((string) $v), $row) : [])
            ->filter(fn ($row) => collect($row)->filter(fn ($v) => $v !== '')->isNotEmpty())
            ->values()
            ->all();

        $about = AboutPage::current();

        // Who-is portrait upload
        if ($request->hasFile('foto')) {
            if ($about->foto) {
                Storage::disk('public')->delete($about->foto);
            }
            $about->foto = $request->file('foto')->store('about', 'public');
        }

        $about->update([
            'quote_text'      => $data['quote_text']      ?? [],
            'quote_author'    => $data['quote_author']    ?? null,
            'foto'            => $about->foto,
            'foto_bw'         => $request->boolean('foto_bw'),
            'founder_title'   => $data['founder_title']   ?? [],
            'founder_text'    => $data['founder_text']    ?? [],
            'institute_title' => $data['institute_title'] ?? [],
            'institute_text'  => $data['institute_text']  ?? [],
            'mission_title'   => $data['mission_title']   ?? [],
            'mission_text'    => $data['mission_text']    ?? [],
            'expertise_title' => $data['expertise_title'] ?? [],
            'expertise_items' => $items,
            'closing_title'   => $data['closing_title']   ?? [],
            'closing_text'    => $data['closing_text']    ?? [],
        ]);

        return redirect()->route('admin.about.edit')->with('success', 'Página "Sobre" actualizada.');
    }
}
