<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlidesController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('ordem')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        [$locale, $defaultLocale] = $this->slideLocales();

        $payload = [
            'ordem'    => (HeroSlide::max('ordem') ?? -1) + 1,
            'tipo'     => $data['tipo'],
            'titulo'   => $this->translatedPayload([], $locale, $defaultLocale, $data['titulo'] ?? null),
            'subtitulo'=> $this->translatedPayload([], $locale, $defaultLocale, $data['subtitulo'] ?? null),
            'ativo'    => $request->boolean('ativo', true),
        ];

        if ($request->hasFile('imagem')) {
            $payload['imagem'] = $request->file('imagem')->store('slides', 'public');
        }
        if ($request->hasFile('video')) {
            $payload['video'] = $request->file('video')->store('slides/videos', 'public');
        }
        if ($request->hasFile('poster')) {
            $payload['poster'] = $request->file('poster')->store('slides', 'public');
        }

        HeroSlide::create($payload);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide criado com sucesso.');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $this->validated($request, $heroSlide);
        [$locale, $defaultLocale] = $this->slideLocales();

        $payload = [
            'tipo'      => $data['tipo'],
            'titulo'    => $this->translatedPayload($heroSlide->titulo, $locale, $defaultLocale, $data['titulo'] ?? null),
            'subtitulo' => $this->translatedPayload($heroSlide->subtitulo, $locale, $defaultLocale, $data['subtitulo'] ?? null),
            'ativo'     => $request->boolean('ativo', true),
        ];

        if ($request->hasFile('imagem')) {
            if ($heroSlide->imagem) Storage::disk('public')->delete($heroSlide->imagem);
            $payload['imagem'] = $request->file('imagem')->store('slides', 'public');
        }
        if ($request->hasFile('video')) {
            if ($heroSlide->video) Storage::disk('public')->delete($heroSlide->video);
            $payload['video'] = $request->file('video')->store('slides/videos', 'public');
        }
        if ($request->hasFile('poster')) {
            if ($heroSlide->poster) Storage::disk('public')->delete($heroSlide->poster);
            $payload['poster'] = $request->file('poster')->store('slides', 'public');
        }

        $heroSlide->update($payload);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide atualizado.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        foreach (['imagem', 'video', 'poster'] as $f) {
            if ($heroSlide->$f) Storage::disk('public')->delete($heroSlide->$f);
        }
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide removido.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            HeroSlide::where('id', (int) $id)->update(['ordem' => $index]);
        }
        return response()->json(['ok' => true]);
    }

    private function validated(Request $request, ?HeroSlide $existing = null): array
    {
        return $request->validate([
            'tipo'            => ['required', 'in:imagem,video'],
            'imagem'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video'           => ['nullable', 'file', 'mimes:mp4,webm,mov,m4v', 'max:51200'], // 50MB
            'poster'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'titulo'          => ['nullable', 'string', 'max:255'],
            'subtitulo'       => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function slideLocales(): array
    {
        $defaultLocale = SiteSetting::query()->value('idioma_padrao') ?: 'pt_BR';
        $locale = app()->getLocale() ?: $defaultLocale;

        return [$locale, $defaultLocale];
    }

    private function translatedPayload($existing, string $locale, string $defaultLocale, ?string $value): array
    {
        $payload = is_array($existing) ? $existing : [];
        $normalized = is_string($value) ? trim($value) : '';

        $payload[$locale] = $normalized;

        if (!isset($payload[$defaultLocale]) || trim((string) $payload[$defaultLocale]) === '' || $locale === $defaultLocale) {
            $payload[$defaultLocale] = $normalized;
        }

        return $payload;
    }
}
