<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LanguagesController extends Controller
{
    private array $builtIn = [
        'pt_BR' => ['name' => 'Português (Brasil)', 'flag' => '🇧🇷', 'dir' => 'ltr', 'mm' => 'pt-BR'],
        'en'    => ['name' => 'English',             'flag' => '🇬🇧', 'dir' => 'ltr', 'mm' => 'en'],
        'es'    => ['name' => 'Español',             'flag' => '🇪🇸', 'dir' => 'ltr', 'mm' => 'es'],
        'he'    => ['name' => 'עברית',               'flag' => '🇮🇱', 'dir' => 'rtl', 'mm' => 'he'],
        'el'    => ['name' => 'Ελληνικά',            'flag' => '🇬🇷', 'dir' => 'ltr', 'mm' => 'el'],
    ];

    public function index()
    {
        $settings  = SiteSetting::current();
        $active    = $settings->idiomas_activos ?? [];
        $languages = $this->getAllLanguages();

        return view('admin.languages', compact('languages', 'active', 'settings'));
    }

    public function toggle(Request $request)
    {
        $locale   = $request->input('locale');
        $settings = SiteSetting::current();
        $active   = $settings->idiomas_activos ?? [];

        if ($locale === $settings->idioma_padrao) {
            return back()->with('error', 'Não é possível desativar o idioma padrão.');
        }

        if (in_array($locale, $active)) {
            $active = array_values(array_filter($active, fn($l) => $l !== $locale));
        } else {
            $active[] = $locale;
        }

        $settings->update(['idiomas_activos' => $active]);

        return back()->with('success', 'Idioma atualizado com sucesso.');
    }

    public function addLanguage(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:10', 'regex:/^[a-z]{2}(_[A-Z]{2})?$/'],
            'name' => ['required', 'string', 'max:100'],
            'dir'  => ['required', 'in:ltr,rtl'],
        ]);

        $code     = $request->input('code');
        $settings = SiteSetting::current();
        $active   = $settings->idiomas_activos ?? [];

        $this->createLanguageFiles($code);

        if (!in_array($code, $active)) {
            $active[] = $code;
            $settings->update(['idiomas_activos' => $active]);
        }

        return back()->with('success', "Idioma '{$code}' adicionado com sucesso.");
    }

    public function editTranslations(string $locale)
    {
        if (!preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $locale)) {
            abort(404);
        }

        $settings     = SiteSetting::current();
        $translations = $this->loadTranslations($locale);
        $ptBR         = $this->loadTranslations('pt_BR');
        $langInfo     = $this->getAllLanguages()[$locale] ?? ['name' => $locale, 'flag' => '🌐', 'dir' => 'ltr'];

        return view('admin.translations.edit', compact('locale', 'translations', 'ptBR', 'settings', 'langInfo'));
    }

    public function updateTranslations(Request $request, string $locale)
    {
        if (!preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $locale)) {
            abort(404);
        }

        $data = $request->input('translations', []);

        foreach ($data as $file => $keys) {
            if (!preg_match('/^[a-z_]+$/', $file)) continue;
            if (!is_array($keys)) continue;
            $this->saveTranslationFile($locale, $file, $keys);
        }

        // Clear translation cache
        app('translator')->setLoaded([]);

        return back()->with('success', 'Traduções guardadas com sucesso.');
    }

    public function autoTranslate(Request $request)
    {
        $request->validate([
            'text'   => ['required', 'string', 'max:1000'],
            'target' => ['required', 'string', 'max:10'],
            'source' => ['nullable', 'string', 'max:10'],
        ]);

        $source = $request->input('source', 'pt-BR');
        $target = $request->input('target');
        $text   = $request->input('text');

        try {
            $response = Http::timeout(8)->get('https://api.mymemory.translated.net/get', [
                'q'        => $text,
                'langpair' => "{$source}|{$target}",
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (($data['responseStatus'] ?? 0) === 200) {
                    $translated = $data['responseData']['translatedText'] ?? '';
                    return response()->json(['translation' => $translated]);
                }
            }

            return response()->json(['error' => 'Tradução não disponível'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro de conexão com serviço de tradução'], 500);
        }
    }

    private function loadTranslations(string $locale): array
    {
        $files        = ['site', 'dashboard', 'auth', 'settings', 'email'];
        $translations = [];

        foreach ($files as $file) {
            $path = lang_path("{$locale}/{$file}.php");
            if (file_exists($path)) {
                $translations[$file] = include $path;
            } else {
                $fallback = lang_path("pt_BR/{$file}.php");
                $translations[$file] = file_exists($fallback) ? include $fallback : [];
            }
        }

        return $translations;
    }

    private function saveTranslationFile(string $locale, string $file, array $keys): void
    {
        $dir = lang_path($locale);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $path    = "{$dir}/{$file}.php";
        $content = "<?php\n\nreturn " . var_export($keys, true) . ";\n";
        file_put_contents($path, $content);
    }

    private function createLanguageFiles(string $code): void
    {
        $files = ['site', 'dashboard', 'auth', 'settings', 'email'];
        $dir   = lang_path($code);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        foreach ($files as $file) {
            $dest = "{$dir}/{$file}.php";
            if (!file_exists($dest)) {
                $src = lang_path("pt_BR/{$file}.php");
                if (file_exists($src)) {
                    copy($src, $dest);
                }
            }
        }
    }

    private function getAllLanguages(): array
    {
        $all     = $this->builtIn;
        $langDir = lang_path();

        if (is_dir($langDir)) {
            foreach (scandir($langDir) as $item) {
                if ($item === '.' || $item === '..') continue;
                if (is_dir($langDir . '/' . $item) && !isset($all[$item])) {
                    $all[$item] = [
                        'name' => strtoupper($item),
                        'flag' => '🌐',
                        'dir'  => 'ltr',
                        'mm'   => $item,
                    ];
                }
            }
        }

        return $all;
    }
}
