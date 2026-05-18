<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::current();

        $smtpConfigured  = !empty($settings->smtp_host) && !empty($settings->smtp_username);
        $activeLanguages = is_array($settings->idiomas_activos) ? count($settings->idiomas_activos) : 0;
        $slidesCount     = HeroSlide::where('ativo', true)->count();

        // Settings completeness score
        $completeness = $this->calcCompleteness($settings);

        return view('admin.dashboard', compact(
            'settings',
            'smtpConfigured',
            'activeLanguages',
            'slidesCount',
            'completeness'
        ));
    }

    private function calcCompleteness(SiteSetting $s): array
    {
        $sections = [
            'Informações Gerais' => [
                'filled' => !empty($s->nome_site) && !empty($s->email_institucional) && !empty($s->telefone),
                'fields' => 'nome, email, telefone',
            ],
            'Mídia (Logo/Favicon)' => [
                'filled' => !empty($s->logo) && !empty($s->favicon),
                'fields' => 'logo, favicon',
            ],
            'Redes Sociais' => [
                'filled' => !empty($s->facebook) || !empty($s->instagram) || !empty($s->linkedin),
                'fields' => 'facebook, instagram, linkedin',
            ],
            'SMTP / Email' => [
                'filled' => !empty($s->smtp_host) && !empty($s->smtp_username) && !empty($s->smtp_password),
                'fields' => 'host, username, password',
            ],
            'SEO' => [
                'filled' => !empty($s->meta_title) && !empty($s->meta_description),
                'fields' => 'meta title, meta description',
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
}
