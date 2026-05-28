<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlossaryTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GlossaryController extends Controller
{
    private array $locales = ['en', 'pt_BR', 'es', 'he', 'el', 'la'];

    private array $letters = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'Z',
    ];

    public function index()
    {
        $terms = GlossaryTerm::whereNotNull('letra')->orderBy('ordem')->orderBy('letra')->orderBy('id')->get();

        return view('admin.glossary.index', compact('terms'));
    }

    public function create()
    {
        $term = new GlossaryTerm([
            'letra' => 'A',
            'termo' => 'A',
            'lingua' => 'en',
            'ativo' => true,
            'destaque' => false,
            'ordem' => (GlossaryTerm::max('ordem') ?? -1) + 1,
        ]);

        return view('admin.glossary.form', [
            'term' => $term,
            'locales' => $this->locales,
            'letters' => $this->letters,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['letra'] ?? 'glossary');

        $this->handleUpload($request, $data, null);

        GlossaryTerm::create($data);

        return redirect()->route('admin.glossary.index')->with('success', 'Letra criada.');
    }

    public function edit(GlossaryTerm $term)
    {
        return view('admin.glossary.form', [
            'term' => $term,
            'locales' => $this->locales,
            'letters' => $this->letters,
        ]);
    }

    public function update(Request $request, GlossaryTerm $term)
    {
        $data = $this->validateData($request, $term->id);

        if (! empty($data['slug']) && $data['slug'] !== $term->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], '', $term->id);
        }

        $this->handleUpload($request, $data, $term);

        $term->update($data);

        return redirect()->route('admin.glossary.index')->with('success', 'Letra actualizada.');
    }

    public function destroy(GlossaryTerm $term)
    {
        if ($term->imagem && ! str_starts_with($term->imagem, 'http')) {
            Storage::disk('public')->delete($term->imagem);
        }

        $term->delete();

        return redirect()->route('admin.glossary.index')->with('success', 'Letra removida.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'slug' => ['nullable', 'string', 'max:150'],
            'letra' => ['required', 'string', 'max:8'],
            'termo' => ['nullable', 'string', 'max:180'],
            'transliteracao' => ['nullable', 'string', 'max:180'],
            'categoria' => ['nullable', 'string', 'max:100'],
            'imagem' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,avif,heic,heif,jfif', 'max:20480'],
            'ordem' => ['nullable', 'integer'],
            'significado' => ['nullable', 'array'],
            'descricao' => ['nullable', 'array'],
        ]);

        foreach (['significado', 'descricao', 'etimologia', 'exemplo_uso', 'citacao_classica', 'citacao_autor'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []));
        }

        $validated['letra'] = strtoupper(trim((string) ($validated['letra'] ?? 'A')));
        $validated['termo'] = trim((string) ($validated['termo'] ?? '')) ?: $validated['letra'];
        $validated['lingua'] = 'en';
        $validated['ativo'] = $request->boolean('ativo');
        $validated['destaque'] = false;

        if (empty($validated['significado']) && ! empty($validated['descricao'])) {
            $validated['significado'] = $validated['descricao'];
        }

        if (empty($validated['descricao']) && ! empty($validated['significado'])) {
            $validated['descricao'] = $validated['significado'];
        }

        return $validated;
    }

    private function cleanLocaleArray(array $data): array
    {
        $out = [];

        foreach ($this->locales as $loc) {
            $value = $data[$loc] ?? null;
            if ($value === null) {
                continue;
            }

            $value = is_string($value) ? trim($value) : $value;
            if ($value !== '' && $value !== null) {
                $out[$loc] = $value;
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
        $base = Str::slug($proposed ?: $fallback ?: 'glossary');
        $slug = $base;
        $i = 2;

        while (
            GlossaryTerm::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
