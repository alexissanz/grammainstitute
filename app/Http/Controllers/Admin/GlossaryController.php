<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlossaryTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GlossaryController extends Controller
{
    private array $locales = ['pt_BR', 'en', 'es', 'he', 'el', 'la'];

    public function index()
    {
        $terms = GlossaryTerm::orderBy('ordem')->orderBy('id')->get();
        return view('admin.glossary.index', compact('terms'));
    }

    public function create()
    {
        $term = new GlossaryTerm([
            'lingua'   => 'el',
            'ativo'    => true,
            'destaque' => false,
            'ordem'    => (GlossaryTerm::max('ordem') ?? -1) + 1,
        ]);
        return view('admin.glossary.form', [
            'term'    => $term,
            'locales' => $this->locales,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['termo'] ?? 'verbete');

        $this->handleUpload($request, $data, null);

        GlossaryTerm::create($data);

        return redirect()->route('admin.glossary.index')->with('success', 'Verbete criado.');
    }

    public function edit(GlossaryTerm $term)
    {
        return view('admin.glossary.form', [
            'term'    => $term,
            'locales' => $this->locales,
        ]);
    }

    public function update(Request $request, GlossaryTerm $term)
    {
        $data = $this->validateData($request, $term->id);
        if (!empty($data['slug']) && $data['slug'] !== $term->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], '', $term->id);
        }

        $this->handleUpload($request, $data, $term);

        $term->update($data);

        return redirect()->route('admin.glossary.index')->with('success', 'Verbete actualizado.');
    }

    public function destroy(GlossaryTerm $term)
    {
        if ($term->imagem && ! str_starts_with($term->imagem, 'http')) {
            Storage::disk('public')->delete($term->imagem);
        }
        $term->delete();
        return redirect()->route('admin.glossary.index')->with('success', 'Verbete removido.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'slug'           => ['nullable', 'string', 'max:150'],
            'termo'          => ['required', 'string', 'max:180'],
            'transliteracao' => ['nullable', 'string', 'max:180'],
            'lingua'         => ['required', 'string', 'max:20'],
            'categoria'      => ['nullable', 'string', 'max:100'],
            'imagem'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'ordem'          => ['nullable', 'integer'],
            'significado'    => ['required', 'array'],
            'significado.pt_BR' => ['required', 'string'],
        ]);

        foreach (['significado', 'descricao', 'etimologia', 'exemplo_uso', 'citacao_classica', 'citacao_autor'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []));
        }

        $validated['ativo']    = $request->boolean('ativo');
        $validated['destaque'] = $request->boolean('destaque');

        return $validated;
    }

    private function cleanLocaleArray(array $data): array
    {
        $out = [];
        foreach ($this->locales as $loc) {
            $v = $data[$loc] ?? null;
            if ($v === null) continue;
            $v = is_string($v) ? trim($v) : $v;
            if ($v !== '' && $v !== null) {
                $out[$loc] = $v;
            }
        }
        return $out;
    }

    private function handleUpload(Request $request, array &$data, ?GlossaryTerm $existing): void
    {
        if ($request->hasFile('imagem')) {
            if ($existing && $existing->imagem && ! str_starts_with($existing->imagem, 'http')) {
                Storage::disk('public')->delete($existing->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('glossary', 'public');
        } else {
            unset($data['imagem']);
        }
    }

    private function uniqueSlug(?string $proposed, string $fallback = '', ?int $ignoreId = null): string
    {
        $base = Str::slug($proposed ?: $fallback ?: 'verbete');
        $slug = $base;
        $i = 2;
        while (GlossaryTerm::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
