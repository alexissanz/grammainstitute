<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
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
        $request->validate([
            'imagem'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'titulo.pt_BR'   => ['required', 'string', 'max:255'],
            'subtitulo.pt_BR'=> ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'ordem'    => (HeroSlide::max('ordem') ?? -1) + 1,
            'titulo'   => $request->input('titulo', []),
            'subtitulo'=> $request->input('subtitulo', []),
            'ativo'    => $request->boolean('ativo', true),
        ];

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('slides', 'public');
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide criado com sucesso.');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'imagem'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'titulo.pt_BR' => ['required', 'string', 'max:255'],
        ]);

        $data = [
            'titulo'    => $request->input('titulo', $heroSlide->titulo ?? []),
            'subtitulo' => $request->input('subtitulo', $heroSlide->subtitulo ?? []),
            'ativo'     => $request->boolean('ativo', true),
        ];

        if ($request->hasFile('imagem')) {
            if ($heroSlide->imagem) {
                Storage::disk('public')->delete($heroSlide->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('slides', 'public');
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide atualizado.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->imagem) {
            Storage::disk('public')->delete($heroSlide->imagem);
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
}
