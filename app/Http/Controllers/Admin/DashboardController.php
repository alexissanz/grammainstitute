<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Event;
use App\Models\GlossaryTerm;
use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Promotion;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::current();

        $stats = [
            'courses'    => Course::count(),
            'courses_on' => Course::where('ativo', true)->count(),
            'events'     => Event::count(),
            'events_up'  => Event::where('ativo', true)
                                 ->where('data_inicio', '>=', now())
                                 ->count(),
            'glossary'   => GlossaryTerm::count(),
            'promos'     => Promotion::count(),
            'promos_on'  => Promotion::where('ativo', true)->count(),
            'slides'     => HeroSlide::count(),
            'slides_on'  => HeroSlide::where('ativo', true)->count(),
            'languages'  => is_array($settings->idiomas_activos) ? count($settings->idiomas_activos) : 0,
        ];

        $smtpConfigured = !empty($settings->smtp_host) && !empty($settings->smtp_username);
        $completeness   = $this->calcCompleteness($settings);
        $mediaHealth    = $this->inspectMediaHealth();

        return view('admin.dashboard', compact(
            'settings', 'stats', 'smtpConfigured', 'completeness', 'mediaHealth'
        ));
    }

    public function maintenance(Request $request, string $task): RedirectResponse
    {
        $tasks = [
            'optimize-clear' => fn () => $this->runArtisanTask('optimize:clear', 'Sistema limpo: cache, views, rotas e configuração.'),
            'view-clear'     => fn () => $this->runArtisanTask('view:clear', 'Views compiladas limpas com sucesso.'),
            'cache-clear'    => fn () => $this->runArtisanTask('cache:clear', 'Cache da aplicação limpo com sucesso.'),
            'route-clear'    => fn () => $this->runArtisanTask('route:clear', 'Cache de rotas limpo com sucesso.'),
            'config-clear'   => fn () => $this->runArtisanTask('config:clear', 'Cache de configuração limpo com sucesso.'),
            'event-clear'    => fn () => $this->runArtisanTask('event:clear', 'Cache de eventos limpo com sucesso.'),
            'repair-media'   => fn () => $this->repairMedia(),
        ];

        if (! isset($tasks[$task])) {
            return redirect()->route('dashboard')->with('error', 'Ferramenta de manutenção inválida.');
        }

        try {
            return redirect()->route('dashboard')->with('success', $tasks[$task]());
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('dashboard')->with(
                'error',
                'Não foi possível executar a manutenção: ' . $e->getMessage()
            );
        }
    }

    private function calcCompleteness(SiteSetting $s): array
    {
        $sections = [
            'identity' => [
                'label'  => 'Identidade',
                'filled' => !empty($s->nome_site) && !empty($s->email_institucional) && !empty($s->telefone),
                'route'  => 'admin.settings.edit',
            ],
            'media' => [
                'label'  => 'Logos & Favicon',
                'filled' => !empty($s->logo) && !empty($s->favicon),
                'route'  => 'admin.settings.edit',
            ],
            'hero' => [
                'label'  => 'Imagem do Hero',
                'filled' => !empty($s->imagem_hero) || HeroSlide::where('ativo', true)->exists(),
                'route'  => 'admin.hero-slides.index',
            ],
            'founder' => [
                'label'  => 'Fundador',
                'filled' => !empty($s->founder_nome) && !empty($s->founder_foto),
                'route'  => 'admin.settings.edit',
            ],
            'social' => [
                'label'  => 'Redes Sociais',
                'filled' => !empty($s->facebook) || !empty($s->instagram) || !empty($s->linkedin),
                'route'  => 'admin.settings.edit',
            ],
            'smtp' => [
                'label'  => 'Servidor SMTP',
                'filled' => !empty($s->smtp_host) && !empty($s->smtp_username) && !empty($s->smtp_password),
                'route'  => 'admin.settings.edit',
            ],
            'seo' => [
                'label'  => 'SEO (meta tags)',
                'filled' => !empty($s->meta_title) && !empty($s->meta_description),
                'route'  => 'admin.settings.edit',
            ],
            'content' => [
                'label'  => 'Cursos publicados',
                'filled' => Course::where('ativo', true)->exists(),
                'route'  => 'admin.courses.index',
            ],
        ];

        $done  = count(array_filter($sections, fn($v) => $v['filled']));
        $total = count($sections);

        return [
            'sections'   => $sections,
            'done'       => $done,
            'total'      => $total,
            'percentage' => $total > 0 ? (int) round($done / $total * 100) : 0,
        ];
    }

    private function runArtisanTask(string $command, string $successMessage): string
    {
        Artisan::call($command);

        return $successMessage;
    }

    private function repairMedia(): string
    {
        $directories = [
            'courses',
            'glossary',
            'partners',
            'site',
            'slides',
            'slides/videos',
        ];

        foreach ($directories as $directory) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $publicStoragePath = public_path('storage');
        if (! File::exists($publicStoragePath)) {
            try {
                Artisan::call('storage:link');
            } catch (\Throwable $e) {
                // On Windows or shared hosting the symlink may already be handled differently.
            }
        }

        $report = $this->inspectMediaHealth();

        return sprintf(
            'Mídia verificada. %d referências conferidas, %d ficheiros válidos, %d em falta.',
            $report['total'],
            $report['ok'],
            $report['missing']
        );
    }

    private function inspectMediaHealth(): array
    {
        $paths = [];
        $settings = SiteSetting::current();

        foreach ([$settings->logo, $settings->logo_rodape, $settings->favicon, $settings->imagem_hero, $settings->hero_video, $settings->founder_foto] as $path) {
            $this->pushMediaPath($paths, $path);
        }

        foreach (Course::all(['imagem_capa', 'imagem_fundo', 'professor_foto']) as $course) {
            $this->pushMediaPath($paths, $course->imagem_capa);
            $this->pushMediaPath($paths, $course->imagem_fundo);
            $this->pushMediaPath($paths, $course->professor_foto);
        }

        foreach (HeroSlide::all(['imagem', 'video', 'poster']) as $slide) {
            $this->pushMediaPath($paths, $slide->imagem);
            $this->pushMediaPath($paths, $slide->video);
            $this->pushMediaPath($paths, $slide->poster);
        }

        foreach (GlossaryTerm::all(['imagem']) as $term) {
            $this->pushMediaPath($paths, $term->imagem);
        }

        foreach (Partner::all(['foto']) as $partner) {
            $this->pushMediaPath($paths, $partner->foto);
        }

        $total = 0;
        $ok = 0;
        $missing = 0;

        foreach (array_unique($paths) as $path) {
            $total++;
            if (Storage::disk('public')->exists($path)) {
                $ok++;
            } else {
                $missing++;
            }
        }

        return compact('total', 'ok', 'missing');
    }

    private function pushMediaPath(array &$paths, mixed $path): void
    {
        if (! is_string($path) || trim($path) === '' || str_starts_with($path, 'http')) {
            return;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        $normalized = preg_replace('#^public/#', '', $normalized) ?: $normalized;

        if ($normalized !== '') {
            $paths[] = $normalized;
        }
    }
}
