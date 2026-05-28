<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('ordem')->orderBy('id')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $payload = [
            'nome'  => $data['nome'],
            'link'  => $data['link'] ?? null,
            'ativo' => $request->boolean('ativo', true),
            'ordem' => (Partner::max('ordem') ?? -1) + 1,
        ];
        if ($request->hasFile('foto')) {
            $payload['foto'] = $request->file('foto')->store('partners', 'public');
        }
        Partner::create($payload);
        return redirect()->route('admin.partners.index')->with('success', 'Parceiro adicionado.');
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validated($request, $partner);
        $payload = [
            'nome'  => $data['nome'],
            'link'  => $data['link'] ?? null,
            'ativo' => $request->boolean('ativo', true),
        ];
        if ($request->hasFile('foto')) {
            if ($partner->foto) Storage::disk('public')->delete($partner->foto);
            $payload['foto'] = $request->file('foto')->store('partners', 'public');
        }
        $partner->update($payload);
        return redirect()->route('admin.partners.index')->with('success', 'Parceiro actualizado.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->foto) Storage::disk('public')->delete($partner->foto);
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Parceiro removido.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $i => $id) {
            Partner::where('id', (int) $id)->update(['ordem' => $i]);
        }
        return response()->json(['ok' => true]);
    }

    private function validated(Request $request, ?Partner $existing = null): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:160'],
            'link' => ['nullable', 'url', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }
}
