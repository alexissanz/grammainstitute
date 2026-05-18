<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    /**
     * Locales we offer translation slots for.
     */
    private array $locales = ['pt_BR', 'en', 'es', 'he', 'el'];

    public function index()
    {
        $courses = Course::orderBy('ordem')->orderBy('id')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $course = new Course([
            'cor_destaque'  => '#a87841',
            'ativo'         => true,
            'destaque'      => false,
            'ordem'         => (Course::max('ordem') ?? -1) + 1,
            'nome'          => [],
            'niveis'        => [],
        ]);
        return view('admin.courses.form', [
            'course'  => $course,
            'locales' => $this->locales,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['nome']['pt_BR'] ?? $data['nome']['en'] ?? 'curso');

        $this->handleUploads($request, $data, null);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Curso criado.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', [
            'course'  => $course,
            'locales' => $this->locales,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validateData($request, $course->id);
        if (!empty($data['slug']) && $data['slug'] !== $course->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], '', $course->id);
        }

        $this->handleUploads($request, $data, $course);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Course $course)
    {
        foreach (['imagem_capa', 'imagem_fundo', 'professor_foto'] as $f) {
            if ($course->$f && ! str_starts_with($course->$f, 'http')) {
                Storage::disk('public')->delete($course->$f);
            }
        }
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Curso removido.');
    }

    /**
     * Validate, then normalise JSON translation fields and the niveis array.
     */
    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $rules = [
            'slug'             => ['nullable', 'string', 'max:100'],
            'codigo'           => ['nullable', 'string', 'max:20'],
            'glifo'            => ['nullable', 'string', 'max:20'],
            'cor_destaque'     => ['nullable', 'string', 'max:10'],
            'imagem_capa'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'imagem_fundo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'professor_foto'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'nome'             => ['required', 'array'],
            'nome.pt_BR'       => ['required', 'string', 'max:255'],
            'duracao_total'    => ['nullable', 'string', 'max:100'],
            'formato'          => ['nullable', 'string', 'max:100'],
            'preco'            => ['nullable', 'string', 'max:100'],
            'vagas_por_turma'  => ['nullable', 'integer', 'min:1', 'max:999'],
            'professor_nome'   => ['nullable', 'string', 'max:180'],
            'contato_whatsapp' => ['nullable', 'string', 'max:30'],
            'contato_email'    => ['nullable', 'email', 'max:255'],
            'contato_telefone' => ['nullable', 'string', 'max:30'],
            'ordem'            => ['nullable', 'integer'],
        ];

        $validated = $request->validate($rules);

        // Collect JSON translation fields
        foreach (['nome', 'subtitulo', 'descricao_curta', 'descricao_longa',
                  'historia_lingua', 'alfabeto_info', 'para_quem',
                  'professor_bio', 'professor_titulos', 'meta_title', 'meta_description'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []));
        }

        // o_que_aprende is an array of bullets per locale
        $bullets = [];
        foreach ($this->locales as $loc) {
            $raw = trim((string) $request->input("o_que_aprende.$loc", ''));
            $lines = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $raw))));
            if ($lines) {
                $bullets[$loc] = $lines;
            }
        }
        $validated['o_que_aprende'] = $bullets;

        // Niveis (array of structured items)
        $niveis = [];
        foreach ((array) $request->input('niveis', []) as $n) {
            if (! is_array($n)) continue;
            $hasName = isset($n['nome']) && is_array($n['nome'])
                && implode('', $n['nome']) !== '';
            if (! $hasName) continue;
            $niveis[] = [
                'nome'      => $this->cleanLocaleArray($n['nome'] ?? []),
                'descricao' => $this->cleanLocaleArray($n['descricao'] ?? []),
                'duracao'   => (string) ($n['duracao'] ?? ''),
            ];
        }
        $validated['niveis'] = $niveis;

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

    private function handleUploads(Request $request, array &$data, ?Course $existing): void
    {
        foreach (['imagem_capa', 'imagem_fundo', 'professor_foto'] as $field) {
            if ($request->hasFile($field)) {
                if ($existing && $existing->$field && ! str_starts_with($existing->$field, 'http')) {
                    Storage::disk('public')->delete($existing->$field);
                }
                $data[$field] = $request->file($field)->store('courses', 'public');
            } else {
                unset($data[$field]);
            }
        }
    }

    private function uniqueSlug(?string $proposed, string $fallback = '', ?int $ignoreId = null): string
    {
        $base = Str::slug($proposed ?: $fallback ?: 'curso');
        $slug = $base;
        $i = 2;
        while (Course::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
