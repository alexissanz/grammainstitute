<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'slug'        => 'noite-de-platao',
                'imagem'      => 'https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=1600&q=85',
                'data_inicio' => now()->addDays(14)->setTime(19, 30),
                'data_fim'    => now()->addDays(14)->setTime(22, 0),
                'formato'     => 'hibrido',
                'gratuito'    => false,
                'preco'       => 'R$ 80 · gratuito para alunos',
                'preco_valor' => 80.00,
                'local_endereco' => 'Rua Augusta, 1234 — Sala dos Manuscritos',
                'local_cidade'   => 'São Paulo',
                'link_online'    => 'https://meet.gramma.test/platao',
                'link_inscricao' => 'https://gramma.test/eventos/noite-de-platao/inscricao',
                'vagas_total'    => 40,
                'vagas_ocupadas' => 12,
                'palestrante_nome' => 'Dr. Aléxios Konstantínou',
                'palestrante_foto' => 'https://images.unsplash.com/photo-1559548331-f9cb98001426?auto=format&fit=crop&w=400&q=85',
                'cor_destaque'   => '#7e5223',
                'destaque'       => true,
                'ordem'          => 1,
                'titulo' => [
                    'pt_BR' => 'Noite de Platão — Leitura do Banquete',
                    'en'    => 'A Platonic Evening — Reading the Symposium',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Tradução comentada do Συμπόσιον com vinho e silêncio',
                    'en'    => 'Annotated reading of the Symposium, with wine and silence',
                ],
                'descricao' => [
                    'pt_BR' => "Uma noite mensal em que escolhemos um diálogo platónico e o lemos do início ao fim, em grego e em português, com pausas, vinho do Peloponeso e tempo para discutir.\n\nNeste serão dedicamos o tempo ao Banquete — o diálogo sobre o amor. Não exigimos saber grego: traduzimos cada passagem ao vivo. O que pedimos é apenas curiosidade e paciência para ouvir.",
                    'en'    => "A monthly evening reading a Platonic dialogue from beginning to end, in Greek and English, with pauses, Peloponnesian wine, and time to talk.\n\nThis evening: the Symposium — Plato's dialogue on love. No Greek required; every passage is translated live. Just bring curiosity and patience.",
                ],
                'local_nome' => [
                    'pt_BR' => 'Sala dos Manuscritos · Gramma SP',
                    'en'    => 'Manuscript Room · Gramma SP',
                ],
                'palestrante_titulo' => [
                    'pt_BR' => 'Fundador · Diretor Académico',
                    'en'    => 'Founder · Academic Director',
                ],
            ],

            [
                'slug'        => 'workshop-alefato',
                'imagem'      => 'https://images.unsplash.com/photo-1544413164-5f1b295eb435?auto=format&fit=crop&w=1600&q=85',
                'data_inicio' => now()->addDays(28)->setTime(10, 0),
                'data_fim'    => now()->addDays(28)->setTime(12, 30),
                'formato'     => 'online',
                'gratuito'    => true,
                'preco'       => null,
                'link_online' => 'https://meet.gramma.test/alefato',
                'link_inscricao' => 'https://gramma.test/eventos/workshop-alefato/inscricao',
                'vagas_total' => 200,
                'vagas_ocupadas' => 73,
                'palestrante_nome' => 'Dra. Yael Ben-Ami',
                'palestrante_foto' => 'https://images.unsplash.com/photo-1573497019418-b400bb3ab074?auto=format&fit=crop&w=400&q=85',
                'cor_destaque'   => '#6c1f1f',
                'destaque'       => true,
                'ordem'          => 2,
                'titulo' => [
                    'pt_BR' => 'Workshop · O Alefato em 2h30',
                    'en'    => 'Workshop · The Aleph-Bet in 2h30',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Aprenda as 22 letras do hebraico — e o que cada uma esconde',
                    'en'    => 'Learn the 22 Hebrew letters — and what each one hides',
                ],
                'descricao' => [
                    'pt_BR' => "Uma masterclass gratuita e prática: ao fim de 2h30 saberá reconhecer todas as 22 consoantes hebraicas, ler o seu nome em hebraico e identificar os pontos vocálicos básicos.\n\nIncluímos uma introdução à numerologia das letras (gematria), porque o alefato é, ao mesmo tempo, um alfabeto, um sistema numérico e um símbolo místico.",
                    'en'    => "A free, hands-on masterclass. In 2h30 you will recognise all 22 Hebrew consonants, read your name in Hebrew, and identify the basic vowel marks.\n\nWe also include a short tour of letter-numerology (gematria), because the Aleph-Bet is at once an alphabet, a number system, and a mystical symbol.",
                ],
                'local_nome' => [
                    'pt_BR' => 'Online · Zoom',
                    'en'    => 'Online · Zoom',
                ],
                'palestrante_titulo' => [
                    'pt_BR' => 'Doutorada · Universidade Hebraica de Jerusalém',
                    'en'    => 'PhD · Hebrew University of Jerusalem',
                ],
            ],

            [
                'slug'        => 'imersao-grega',
                'imagem'      => 'https://images.unsplash.com/photo-1555993539-1732b0258235?auto=format&fit=crop&w=1600&q=85',
                'data_inicio' => now()->addDays(45)->setTime(9, 0),
                'data_fim'    => now()->addDays(52)->setTime(18, 0),
                'formato'     => 'presencial',
                'gratuito'    => false,
                'preco'       => 'A partir de R$ 4.200',
                'preco_valor' => 4200.00,
                'local_endereco' => 'Atenas — Hotel Plaka & Acrópole',
                'local_cidade'   => 'Atenas',
                'link_inscricao' => 'https://gramma.test/eventos/imersao-grega/inscricao',
                'vagas_total'    => 16,
                'vagas_ocupadas' => 5,
                'palestrante_nome' => 'Dr. Aléxios Konstantínou',
                'palestrante_foto' => 'https://images.unsplash.com/photo-1559548331-f9cb98001426?auto=format&fit=crop&w=400&q=85',
                'cor_destaque'   => '#a87841',
                'destaque'       => false,
                'ordem'          => 3,
                'titulo' => [
                    'pt_BR' => 'Imersão Grega · 7 dias em Atenas',
                    'en'    => 'Greek Immersion · 7 days in Athens',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Aulas matinais, visitas guiadas à tarde, leitura ao pôr-do-sol',
                    'en'    => 'Morning classes, guided visits in the afternoon, sunset readings',
                ],
                'descricao' => [
                    'pt_BR' => "Sete dias em Atenas com aulas de grego pela manhã, visitas guiadas a sítios arqueológicos à tarde e leitura de textos clássicos ao pôr-do-sol, na colina de Filopapo.\n\nDelfos, Sounion, Egina e Plaka. Pequenos grupos, apoio logístico completo. Vôo não incluído.",
                ],
                'local_nome' => ['pt_BR' => 'Atenas, Grécia'],
                'palestrante_titulo' => ['pt_BR' => 'Direção académica acompanha a viagem'],
            ],

            [
                'slug'        => 'aberto-portas',
                'imagem'      => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1600&q=85',
                'data_inicio' => now()->addDays(7)->setTime(15, 0),
                'data_fim'    => now()->addDays(7)->setTime(18, 0),
                'formato'     => 'presencial',
                'gratuito'    => true,
                'link_inscricao' => 'https://gramma.test/eventos/aberto-portas/inscricao',
                'vagas_total' => 80,
                'vagas_ocupadas' => 22,
                'cor_destaque' => '#4f5b35',
                'ordem' => 4,
                'titulo' => [
                    'pt_BR' => 'Tarde de portas abertas',
                    'en'    => 'Open Afternoon',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Visite a escola, conheça os professores, ouça uma aula-demonstração',
                    'en'    => 'Visit the school, meet the teachers, attend a demo class',
                ],
                'descricao' => [
                    'pt_BR' => "Três horas de portas abertas: às 15h00 visita guiada à escola e à biblioteca; às 16h00 aula-demonstração de grego clássico; às 17h00 conversa com os professores e café com bolo grego.",
                ],
                'local_nome' => ['pt_BR' => 'Sede Gramma — São Paulo'],
            ],
        ];

        foreach ($events as $e) {
            Event::updateOrCreate(['slug' => $e['slug']], $e);
        }
    }
}
