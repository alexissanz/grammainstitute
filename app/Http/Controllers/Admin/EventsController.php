<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    private array $locales = ['pt_BR', 'en', 'es', 'he', 'el', 'la'];

    public function index()
    {
        $events = Event::orderByDesc('data_inicio')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $event = new Event([
            'cor_destaque' => '#a87841',
            'formato'      => 'presencial',
            'gratuito'     => true,
            'moeda'        => 'BRL',
            'timezone'     => 'America/Sao_Paulo',
            'ativo'        => true,
            'destaque'     => false,
            'data_inicio'  => now()->addDays(7)->setTime(19, 0),
        ]);
        return view('admin.events.form', [
            'event'   => $event,
            'locales' => $this->locales,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['titulo']['pt_BR'] ?? 'evento');
        $this->handleUploads($request, $data, null);

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Evento criado.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', [
            'event'   => $event,
            'locales' => $this->locales,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validateData($request, $event->id);
        if (!empty($data['slug']) && $data['slug'] !== $event->slug) {
            $data['slug'] = $this->uniqueSlug($data['slug'], '', $event->id);
        }
        $this->handleUploads($request, $data, $event);
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event)
    {
        foreach (['imagem', 'palestrante_foto'] as $f) {
            if ($event->$f && ! str_starts_with($event->$f, 'http')) {
                Storage::disk('public')->delete($event->$f);
            }
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento removido.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'slug'             => ['nullable', 'string', 'max:150'],
            'imagem'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'palestrante_foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'data_inicio'      => ['required', 'date'],
            'data_fim'         => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'timezone'         => ['nullable', 'string', 'max:60'],
            'titulo'           => ['required', 'array'],
            'titulo.pt_BR'     => ['required', 'string', 'max:255'],
            'local_endereco'   => ['nullable', 'string', 'max:255'],
            'local_cidade'     => ['nullable', 'string', 'max:100'],
            'formato'          => ['required', 'in:presencial,online,hibrido'],
            'link_online'      => ['nullable', 'string', 'max:500'],
            'preco'            => ['nullable', 'string', 'max:100'],
            'preco_valor'      => ['nullable', 'numeric', 'min:0'],
            'moeda'            => ['nullable', 'string', 'max:10'],
            'link_inscricao'   => ['nullable', 'string', 'max:500'],
            'vagas_total'      => ['nullable', 'integer', 'min:1'],
            'vagas_ocupadas'   => ['nullable', 'integer', 'min:0'],
            'palestrante_nome' => ['nullable', 'string', 'max:180'],
            'cor_destaque'     => ['nullable', 'string', 'max:10'],
            'ordem'            => ['nullable', 'integer'],
        ]);

        foreach (['titulo', 'subtitulo', 'descricao', 'local_nome', 'palestrante_titulo'] as $field) {
            $validated[$field] = $this->cleanLocaleArray($request->input($field, []));
        }

        $validated['gratuito'] = $request->boolean('gratuito');
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
            if ($v !== '' && $v !== null) $out[$loc] = $v;
        }
        return $out;
    }

    private function handleUploads(Request $request, array &$data, ?Event $existing): void
    {
        foreach (['imagem', 'palestrante_foto'] as $field) {
            if ($request->hasFile($field)) {
                if ($existing && $existing->$field && ! str_starts_with($existing->$field, 'http')) {
                    Storage::disk('public')->delete($existing->$field);
                }
                $data[$field] = $request->file($field)->store('events', 'public');
            } else {
                unset($data[$field]);
            }
        }
    }

    private function uniqueSlug(?string $proposed, string $fallback = '', ?int $ignoreId = null): string
    {
        $base = Str::slug($proposed ?: $fallback ?: 'evento');
        $slug = $base; $i = 2;
        while (Event::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
