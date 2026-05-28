<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use App\Models\ResourceLink;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function index()
    {
        $categories = ResourceCategory::with('links')->orderBy('ordem')->orderBy('id')->get();
        return view('admin.resources.index', compact('categories'));
    }

    /* ============================ CATEGORIES ============================ */

    public function createCategory()
    {
        return view('admin.resources.category', [
            'category'  => new ResourceCategory(['ativo' => true]),
            'languages' => $this->languages(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $data = $this->validatedCategory($request);
        ResourceCategory::create([
            'slug'        => $data['slug'],
            'title'       => $data['title'] ?? [],
            'description' => $data['description'] ?? [],
            'icon'        => $data['icon'] ?? null,
            'ordem'       => (ResourceCategory::max('ordem') ?? -1) + 1,
            'ativo'       => $request->boolean('ativo', true),
        ]);
        return redirect()->route('admin.resources.index')->with('success', 'Categoria criada.');
    }

    public function editCategory(ResourceCategory $category)
    {
        return view('admin.resources.category', [
            'category'  => $category,
            'languages' => $this->languages(),
        ]);
    }

    public function updateCategory(Request $request, ResourceCategory $category)
    {
        $data = $this->validatedCategory($request, $category);
        $category->update([
            'slug'        => $data['slug'],
            'title'       => $data['title'] ?? [],
            'description' => $data['description'] ?? [],
            'icon'        => $data['icon'] ?? null,
            'ativo'       => $request->boolean('ativo', true),
        ]);
        return redirect()->route('admin.resources.editCategory', $category)->with('success', 'Categoria actualizada.');
    }

    public function destroyCategory(ResourceCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.resources.index')->with('success', 'Categoria removida.');
    }

    public function reorderCategories(Request $request)
    {
        foreach ($request->input('order', []) as $i => $id) {
            ResourceCategory::where('id', (int) $id)->update(['ordem' => $i]);
        }
        return response()->json(['ok' => true]);
    }

    /* ============================ LINKS ============================ */

    public function storeLink(Request $request, ResourceCategory $category)
    {
        $data = $this->validatedLink($request);
        ResourceLink::create([
            'category_id' => $category->id,
            'grupo'       => $data['grupo'] ?? null,
            'grupo_ordem' => (int) ($data['grupo_ordem'] ?? 0),
            'title'       => $data['title'] ?? [],
            'description' => $data['description'] ?? [],
            'url'         => $data['url'],
            'ordem'       => ($category->links()->max('ordem') ?? -1) + 1,
            'ativo'       => $request->boolean('ativo', true),
        ]);
        return redirect()->route('admin.resources.editCategory', $category)->with('success', 'Link adicionado.');
    }

    public function updateLink(Request $request, ResourceCategory $category, ResourceLink $link)
    {
        abort_unless($link->category_id === $category->id, 404);
        $data = $this->validatedLink($request);
        $link->update([
            'grupo'       => $data['grupo'] ?? null,
            'grupo_ordem' => (int) ($data['grupo_ordem'] ?? 0),
            'title'       => $data['title'] ?? [],
            'description' => $data['description'] ?? [],
            'url'         => $data['url'],
            'ativo'       => $request->boolean('ativo', true),
        ]);
        return redirect()->route('admin.resources.editCategory', $category)->with('success', 'Link actualizado.');
    }

    public function destroyLink(ResourceCategory $category, ResourceLink $link)
    {
        abort_unless($link->category_id === $category->id, 404);
        $link->delete();
        return redirect()->route('admin.resources.editCategory', $category)->with('success', 'Link removido.');
    }

    public function reorderLinks(Request $request, ResourceCategory $category)
    {
        foreach ($request->input('order', []) as $i => $id) {
            ResourceLink::where('id', (int) $id)
                ->where('category_id', $category->id)
                ->update(['ordem' => $i]);
        }
        return response()->json(['ok' => true]);
    }

    /* ============================ helpers ============================ */

    private function validatedCategory(Request $request, ?ResourceCategory $existing = null): array
    {
        return $request->validate([
            'slug'             => ['required', 'string', 'max:80', 'regex:/^[a-z0-9-]+$/',
                                   'unique:resource_categories,slug,' . ($existing?->id ?? 'NULL')],
            'icon'             => ['nullable', 'string', 'max:60'],
            'title'            => ['array'],
            'title.*'          => ['nullable', 'string', 'max:160'],
            'description'      => ['array'],
            'description.*'    => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function validatedLink(Request $request): array
    {
        return $request->validate([
            // Allow a real http(s) URL or a "#" placeholder (to be completed later).
            'url'           => ['required', 'string', 'max:500', 'regex:/^(https?:\/\/.+|#)$/'],
            'grupo'         => ['nullable', 'string', 'max:160'],
            'grupo_ordem'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'title'         => ['array'],
            'title.*'       => ['nullable', 'string', 'max:160'],
            'description'   => ['array'],
            'description.*' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function languages(): array
    {
        $settings = SiteSetting::current();
        $all = [
            'pt_BR' => ['flag' => '🇧🇷', 'name' => 'PT-BR'],
            'en'    => ['flag' => '🇬🇧', 'name' => 'EN'],
            'es'    => ['flag' => '🇪🇸', 'name' => 'ES'],
            'he'    => ['flag' => '🇮🇱', 'name' => 'HE'],
            'el'    => ['flag' => '🇬🇷', 'name' => 'EL'],
            'la'    => ['flag' => '🏛',   'name' => 'LA'],
        ];
        $codes = $settings->idiomas_activos ?? array_keys($all);
        return array_intersect_key($all, array_flip($codes)) ?: $all;
    }
}
