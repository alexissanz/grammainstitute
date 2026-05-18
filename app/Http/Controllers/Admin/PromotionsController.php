<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionsController extends Controller
{
    private array $locales = ['pt_BR', 'en', 'es', 'he', 'el', 'la'];

    public function index()
    {
        $promotions = Promotion::orderBy('ordem')->orderByDesc('id')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $promotion = new Promotion([
            'cor_fundo'      => '#1a1612',
            'cor_texto'      => '#faf6ec',
            'cor_destaque'   => '#c8a44b',
            'mostrar_home'   => true,
            'mostrar_topbar' => false,
            'mostrar_popup'  => false,
            'ativo'          => true,
        ]);
        return view('admin.promotions.form', [
            'promotion' => $promotion,
            'locales'   => $this->locales,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['titulo']['pt_BR'] ?? 'promo');
        $this->handleUpload($request, $data, null);

        Promotion::create($data);
        return redirect()->route('admin.promotions.index')->with('success', 'Promoção criada.');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.form', [
            'promotion' => $promotion,
            'locales'   => $this->locales,
        ]);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $this->validateData($request, $promotion->id);
        if (!empty($data['slug']) && $data['slug'] !== $promotion->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], '', $promotion->id);
        }
        $this->handleUpload($request, $data, $promotion);
        $promotion->update($data);
        return redirect()->route('admin.promotions.index')->with('success', 'Promoção actualizada.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->imagem && ! str_starts_with($promotion->imagem, 'http')) {
            Storage::disk('public')->delete($promotion->imagem);
        }
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promoção removida.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'slug'         => ['nullable', 'string', 'max:150'],
            'imagem'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'titulo'       => ['required', 'array'],
            'titulo.pt_BR' => ['required', 'string', 'max:255'],
            'cor_fundo'    => ['nullable', 'string', 'max:10'],
            'cor_texto'    => ['nullable', 'string', 'max:10'],
            'cor_destaque' => ['nullable', 'string', 'max:10'],
            'cta_url'      => ['nullable', 'string', 'max:500'],
            'codigo_promo' => ['nullable', 'string', 'max:60'],
            'desconto'     => ['nullable', 'string', 'max:60'],
            'inicio'       => ['nullable', 'date'],
            'fim'          => ['nullable', 'date', 'after_or_equal:inicio'],
            'ordem'        => ['nullable', 'integer'],
        ]);

        foreach (['titulo', 'subtitulo', 'descricao', 'badge_texto', 'cta_texto'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []));
        }

        $validated['mostrar_topbar'] = $request->boolean('mostrar_topbar');
        $validated['mostrar_home']   = $request->boolean('mostrar_home');
        $validated['mostrar_popup']  = $request->boolean('mostrar_popup');
        $validated['ativo']          = $request->boolean('ativo');

        return $validated;
    }

    private function cleanLocaleArray(array $data): array
    {
        $out = [];
        foreach ($this->locales as $loc) {
            $v = $data[$loc] ?? null;
            if ($v === null) continue;
            $v = is_string($v) ? trim($v) : $v;
            if ($v !== '' && $v !== null) $out[$loc] = $v;
        }
        return $out;
    }

    private function handleUpload(Request $request, array &$data, ?Promotion $existing): void
    {
        if ($request->hasFile('imagem')) {
            if ($existing && $existing->imagem && ! str_starts_with($existing->imagem, 'http')) {
                Storage::disk('public')->delete($existing->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('promotions', 'public');
        } else {
            unset($data['imagem']);
        }
    }

    private function uniqueSlug(?string $proposed, string $fallback = '', ?int $ignoreId = null): string
    {
        $base = Str::slug($proposed ?: $fallback ?: 'promo');
        $slug = $base; $i = 2;
        while (Promotion::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
