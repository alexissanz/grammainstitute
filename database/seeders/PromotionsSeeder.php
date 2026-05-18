<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionsSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::updateOrCreate(['slug' => 'turma-de-inverno-2026'], [
            'slug'           => 'turma-de-inverno-2026',
            'imagem'         => 'https://images.unsplash.com/photo-1564660677770-7eea29ce4e3a?auto=format&fit=crop&w=1600&q=85',
            'cor_fundo'      => '#1a1612',
            'cor_texto'      => '#faf6ec',
            'cor_destaque'   => '#c8a44b',
            'cta_url'        => '/courses',
            'codigo_promo'   => 'INVERNO26',
            'desconto'       => '20% OFF',
            'inicio'         => now()->subDays(2),
            'fim'            => now()->addDays(20),
            'mostrar_topbar' => true,
            'mostrar_home'   => true,
            'mostrar_popup'  => false,
            'ordem'          => 1,
            'ativo'          => true,
            'titulo' => [
                'pt_BR' => 'Turma de Inverno 2026 — 20% OFF',
                'en'    => 'Winter Cohort 2026 — 20% OFF',
                'es'    => 'Cohorte de Invierno 2026 — 20% OFF',
            ],
            'subtitulo' => [
                'pt_BR' => 'Inscrições abertas até 5 de Junho · novos alunos',
                'en'    => 'Enrolment open until June 5th · new students',
                'es'    => 'Inscripciones hasta el 5 de Junio · nuevos alumnos',
            ],
            'descricao' => [
                'pt_BR' => 'Uma vez por ano abrimos turmas de inverno em todos os idiomas com desconto integral no primeiro semestre. Use o código INVERNO26 ao inscrever-se.',
                'en'    => 'Once a year we open winter cohorts in every language at full discount for the first semester. Use code INVERNO26 at sign-up.',
            ],
            'badge_texto' => [
                'pt_BR' => 'Por tempo limitado',
                'en'    => 'Limited time',
            ],
            'cta_texto' => [
                'pt_BR' => 'Garantir o desconto',
                'en'    => 'Claim the discount',
            ],
        ]);

        Promotion::updateOrCreate(['slug' => 'aula-experimental'], [
            'slug'           => 'aula-experimental',
            'cor_fundo'      => '#6c1f1f',
            'cor_texto'      => '#faf6ec',
            'cor_destaque'   => '#e7c873',
            'cta_url'        => '/contact',
            'desconto'       => null,
            'inicio'         => now()->subDays(30),
            'fim'            => now()->addDays(60),
            'mostrar_topbar' => false,
            'mostrar_home'   => true,
            'mostrar_popup'  => false,
            'ordem'          => 2,
            'ativo'          => true,
            'titulo' => [
                'pt_BR' => 'Uma aula experimental, sem custo',
                'en'    => 'A free trial class',
            ],
            'subtitulo' => [
                'pt_BR' => 'Veja por dentro como ensinamos. Sem compromisso.',
                'en'    => "See firsthand how we teach. No commitment.",
            ],
            'badge_texto' => [
                'pt_BR' => 'Gratuito',
                'en'    => 'Free',
            ],
            'cta_texto' => [
                'pt_BR' => 'Agendar aula',
                'en'    => 'Book a class',
            ],
        ]);
    }
}
