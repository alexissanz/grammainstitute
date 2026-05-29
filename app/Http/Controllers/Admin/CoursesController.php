<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = $this->visibleCoursesQuery()->orderBy('ordem')->orderBy('id')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $course = new Course([
            'cor_destaque'  => '#a87841',
            'ativo'         => true,
            'destaque'      => false,
            'material_gratis' => true,
            'certificacao_gratis' => true,
            'ordem'         => (Course::max('ordem') ?? -1) + 1,
            'nome'          => [],
            'niveis'        => [],
        ]);
        return view('admin.courses.form', [
            'course'  => $course,
            'locales' => $this->orderedLocales(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $this->validateData($request);
            [$defaultLocale] = $this->localeMeta();
            $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['nome'][$defaultLocale] ?? $data['nome']['en'] ?? $data['nome']['pt_BR'] ?? 'course');

            $this->handleUploads($request, $data, null);

            Course::create($data);

            return redirect()->route('admin.courses.index')->with('success', 'Curso criado.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Erro ao criar curso', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'save' => 'Não foi possível criar o curso agora. Motivo: ' . $e->getMessage(),
                ]);
        }
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', [
            'course'  => $course,
            'locales' => $this->orderedLocales(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        try {
            $data = $this->validateData($request, $course->id);
            [$defaultLocale] = $this->localeMeta();
            $desiredSlug = $data['slug'] ?? null;
            if (blank($desiredSlug)) {
                $data['slug'] = $course->slug ?: $this->uniqueSlug(
                    null,
                    $data['nome'][$defaultLocale] ?? $data['nome']['en'] ?? $data['nome']['pt_BR'] ?? 'course',
                    $course->id
                );
            } elseif ($desiredSlug !== $course->slug) {
                $data['slug'] = $this->uniqueSlug($desiredSlug, '', $course->id);
            } else {
                $data['slug'] = $course->slug;
            }

            // Hard guarantee: slug is NOT NULL in the DB, never let it be empty.
            if (blank($data['slug'])) {
                $data['slug'] = $this->uniqueSlug(null, $data['nome'][$defaultLocale] ?? 'course', $course->id);
            }

            $this->handleUploads($request, $data, $course);

            $course->update($data);

            return redirect()->route('admin.courses.index')->with('success', 'Curso actualizado.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Erro ao actualizar curso', [
                'course_id' => $course->id,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'save' => 'Não foi possível guardar as alterações deste curso. Motivo: ' . $e->getMessage(),
                ]);
        }
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
        [$defaultLocale, $locales] = $this->localeMeta();
        $rules = [
            'slug'             => ['nullable'],
            'codigo'           => ['nullable'],
            'glifo'            => ['nullable'],
            'cor_destaque'     => ['nullable'],
            'imagem_capa'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,avif,heic,heif,jfif', 'max:20480'],
            'imagem_fundo'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,avif,heic,heif,jfif', 'max:20480'],
            'professor_foto'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,bmp,avif,heic,heif,jfif', 'max:20480'],
            'nome'             => ['nullable', 'array'],
            'duracao_total'    => ['nullable'],
            'formato'          => ['nullable'],
            'preco'            => ['nullable'],
            'vagas_por_turma'  => ['nullable'],
            'material_gratis'  => ['nullable'],
            'material_gratis_texto' => ['nullable'],
            'certificacao_gratis' => ['nullable'],
            'certificacao_gratis_texto' => ['nullable'],
            'professor_nome'   => ['nullable'],
            'contato_whatsapp' => ['nullable'],
            'contato_email'    => ['nullable'],
            'contato_telefone' => ['nullable'],
            'ordem'            => ['nullable'],
        ];

        $messages = [
            'imagem_capa.image' => 'A capa do curso deve ser uma imagem válida.',
            'imagem_capa.mimes' => 'A capa do curso deve estar em JPG, PNG ou WebP.',
            'imagem_capa.max' => 'A capa do curso não pode ter mais de 12MB.',
            'imagem_fundo.image' => 'O banner do curso deve ser uma imagem válida.',
            'imagem_fundo.mimes' => 'O banner do curso deve estar em JPG, PNG ou WebP.',
            'imagem_fundo.max' => 'O banner do curso não pode ter mais de 12MB.',
            'professor_foto.image' => 'A foto do professor deve ser uma imagem válida.',
            'professor_foto.mimes' => 'A foto do professor deve estar em JPG, PNG ou WebP.',
            'professor_foto.max' => 'A foto do professor não pode ter mais de 8MB.',
        ];

        $messages = array_merge($messages, [
            'imagem_capa.mimes' => 'A capa do curso deve estar em JPG, JPEG, PNG, WebP, GIF, BMP, AVIF, HEIC, HEIF ou JFIF.',
            'imagem_capa.max' => 'A capa do curso nao pode ter mais de 20MB.',
            'imagem_fundo.mimes' => 'O banner do curso deve estar em JPG, JPEG, PNG, WebP, GIF, BMP, AVIF, HEIC, HEIF ou JFIF.',
            'imagem_fundo.max' => 'O banner do curso nao pode ter mais de 20MB.',
            'professor_foto.mimes' => 'A foto do professor deve estar em JPG, JPEG, PNG, WebP, GIF, BMP, AVIF, HEIC, HEIF ou JFIF.',
            'professor_foto.max' => 'A foto do professor nao pode ter mais de 20MB.',
        ]);

        $validated = $request->validate($rules, $messages);

        // Collect JSON translation fields
        foreach (['nome', 'subtitulo', 'descricao_curta', 'descricao_longa',
                  'historia_lingua', 'alfabeto_info', 'para_quem',
                  'professor_bio', 'professor_titulos', 'meta_title', 'meta_description'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []), $defaultLocale, $locales);
        }

        if (empty($validated['nome'])) {
            if ($ignoreId) {
                $existingCourse = Course::find($ignoreId);
                $validated['nome'] = $existingCourse?->nome ?: [$defaultLocale => 'Untitled course'];
            } else {
                $validated['nome'] = [$defaultLocale => 'New course'];
            }
        }

        // o_que_aprende is an array of bullets per locale
        $bullets = [];
        foreach ($locales as $loc) {
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
                'nome'      => $this->cleanLocaleArray($n['nome'] ?? [], $defaultLocale, $locales),
                'descricao' => $this->cleanLocaleArray($n['descricao'] ?? [], $defaultLocale, $locales),
                'duracao'   => (string) ($n['duracao'] ?? ''),
            ];
        }
        $validated['niveis'] = $niveis;

        $validated['ativo']    = $request->boolean('ativo');
        $validated['destaque'] = $request->boolean('destaque');
        $validated['material_gratis'] = $request->boolean('material_gratis');
        $validated['certificacao_gratis'] = $request->boolean('certificacao_gratis');

        $validated = $this->normalizeScalarFields($validated);

        return $validated;
    }

    private function normalizeScalarFields(array $data): array
    {
        $data['slug'] = $this->limitString($data['slug'] ?? null, 100);
        $data['codigo'] = $this->limitString($data['codigo'] ?? null, 20);
        $data['glifo'] = $this->limitString($data['glifo'] ?? null, 20);
        $data['cor_destaque'] = $this->limitString($data['cor_destaque'] ?? null, 10) ?: '#a87841';
        $data['duracao_total'] = $this->limitString($data['duracao_total'] ?? null, 100);
        $data['formato'] = $this->limitString($data['formato'] ?? null, 100);
        $data['preco'] = $this->limitString($data['preco'] ?? null, 100);
        $data['material_gratis_texto'] = $this->limitString($data['material_gratis_texto'] ?? null, 180);
        $data['certificacao_gratis_texto'] = $this->limitString($data['certificacao_gratis_texto'] ?? null, 180);
        $data['professor_nome'] = $this->limitString($data['professor_nome'] ?? null, 180);
        $data['contato_whatsapp'] = $this->limitString($data['contato_whatsapp'] ?? null, 30);
        $data['contato_email'] = $this->limitString($data['contato_email'] ?? null, 255);
        $data['contato_telefone'] = $this->limitString($data['contato_telefone'] ?? null, 30);
        $data['vagas_por_turma'] = $this->normalizeIntOrNull($data['vagas_por_turma'] ?? null, 1, 999);
        $data['ordem'] = $this->normalizeIntOrNull($data['ordem'] ?? null) ?? 0;

        return $data;
    }

    private function limitString(mixed $value, int $max): ?string
    {
        if (is_array($value) || is_object($value)) {
            return null;
        }

        $value = trim((string) ($value ?? ''));

        if ($value === '') {
            return null;
        }

        return Str::limit($value, $max, '');
    }

    private function normalizeIntOrNull(mixed $value, ?int $min = null, ?int $max = null): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        $value = (int) $value;

        if ($min !== null && $value < $min) {
            $value = $min;
        }

        if ($max !== null && $value > $max) {
            $value = $max;
        }

        return $value;
    }

    private function cleanLocaleArray(array $data, string $defaultLocale, array $locales): array
    {
        $out = [];
        foreach ($locales as $loc) {
            $v = $data[$loc] ?? null;
            if ($v === null) continue;
            $v = is_string($v) ? trim($v) : $v;
            if ($v !== '' && $v !== null) {
                $out[$loc] = $v;
            }
        }

        if (!isset($out[$defaultLocale]) || trim((string) $out[$defaultLocale]) === '') {
            foreach ($out as $value) {
                if (is_string($value) && trim($value) !== '') {
                    $out[$defaultLocale] = $value;
                    break;
                }
            }
        }

        return $out;
    }

    private function handleUploads(Request $request, array &$data, ?Course $existing): void
    {
        $newCoverUploaded = false;

        foreach (['imagem_capa', 'imagem_fundo', 'professor_foto'] as $field) {
            if ($request->hasFile($field)) {
                if ($existing && $existing->$field && ! str_starts_with($existing->$field, 'http')) {
                    Storage::disk('public')->delete($existing->$field);
                }
                $data[$field] = $request->file($field)->store('courses', 'public');
                if ($field === 'imagem_capa') {
                    $newCoverUploaded = true;
                }
            } else {
                unset($data[$field]);
            }
        }

        if ($existing && $newCoverUploaded && ! $request->hasFile('imagem_fundo') && ! empty($existing->imagem_fundo)) {
            if (! str_starts_with($existing->imagem_fundo, 'http')) {
                Storage::disk('public')->delete($existing->imagem_fundo);
            }
            $data['imagem_fundo'] = null;
        }
    }

    private function uniqueSlug(?string $proposed, string $fallback = '', ?int $ignoreId = null): string
    {
        $base = Str::slug($proposed ?: $fallback ?: 'course');
        $slug = $base;
        $i = 2;
        while (Course::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function localeMeta(): array
    {
        $settings = SiteSetting::current();
        $defaultLocale = $settings->idioma_padrao ?: 'en';
        $activeLocales = array_values(array_filter($settings->idiomas_activos ?? []));
        $locales = $activeLocales ?: ['en', 'pt_BR', 'es', 'he', 'el', 'la'];

        if (!in_array($defaultLocale, $locales, true)) {
            array_unshift($locales, $defaultLocale);
        }

        return [$defaultLocale, array_values(array_unique($locales))];
    }

    private function orderedLocales(): array
    {
        [, $locales] = $this->localeMeta();

        return $locales;
    }

    private function visibleCoursesQuery()
    {
        return Course::query()->whereNotIn('slug', [
            'espanhol',
            'portugues',
            'portugues-para-estrangeiros-ple',
            'portuguese-for-foreigners-pfl',
        ]);
    }
}
