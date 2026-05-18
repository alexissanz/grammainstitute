<?php

namespace Database\Seeders;

use App\Models\GlossaryTerm;
use Illuminate\Database\Seeder;

class GlossarySeeder extends Seeder
{
    public function run(): void
    {
        $terms = [
            [
                'slug'           => 'logos',
                'termo'          => 'Λόγος',
                'transliteracao' => 'lógos',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'destaque'       => true,
                'ordem'          => 1,
                'imagem'         => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1200&q=85',
                'significado'    => [
                    'pt_BR' => 'Palavra, razão, princípio ordenador. Um dos conceitos mais densos do pensamento grego — chega a designar o próprio fundamento racional do cosmos.',
                    'en'    => 'Word, reason, ordering principle. One of the most dense concepts in Greek thought — it can mean the rational foundation of the cosmos itself.',
                ],
                'descricao' => [
                    'pt_BR' => "Em Heráclito, Λόγος é o princípio invisível que rege todas as coisas — \"todas as coisas se cumprem segundo este Λόγος.\" Em Platão e Aristóteles, designa a faculdade racional que distingue o ser humano. No prólogo do Evangelho de João, é elevado a categoria teológica: \"No princípio era o Λόγος, e o Λόγος estava com Deus, e o Λόγος era Deus.\" Cada estrato do termo deixa marcas no português: lógica, biologia, antropologia — todos os -logos vêm daqui.",
                    'en'    => "In Heraclitus, Λόγος is the invisible principle that governs all things — \"all things come to pass in accordance with this Λόγος.\" In Plato and Aristotle it designates the rational faculty that distinguishes humans. In the prologue of John, it is elevated to theological dignity: \"In the beginning was the Λόγος.\" Every layer of the term leaves its mark on modern languages: logic, biology, anthropology — all the -logies come from here.",
                ],
                'etimologia' => [
                    'pt_BR' => 'Da raiz indo-europeia *leǵ-, "recolher, escolher, dizer". Cognato do latim legere (ler) e lex (lei).',
                    'en'    => 'From PIE *leǵ-, "to gather, choose, say." Cognate with Latin legere (to read) and lex (law).',
                ],
                'exemplo_uso' => [
                    'pt_BR' => '"ὁ Λόγος σὰρξ ἐγένετο" — "o Verbo se fez carne" (João 1,14).',
                    'en'    => '"ὁ Λόγος σὰρξ ἐγένετο" — "the Word became flesh" (John 1:14).',
                ],
                'citacao_classica' => [
                    'pt_BR' => 'τοῦ Λόγου δὲ ἐόντος ξυνοῦ ζώουσιν οἱ πολλοὶ ὡς ἰδίαν ἔχοντες φρόνησιν.',
                    'en'    => 'τοῦ Λόγου δὲ ἐόντος ξυνοῦ ζώουσιν οἱ πολλοὶ ὡς ἰδίαν ἔχοντες φρόνησιν.',
                ],
                'citacao_autor' => ['pt_BR' => 'Heráclito, fragmento DK 22 B 2'],
            ],

            [
                'slug'           => 'arete',
                'termo'          => 'Ἀρετή',
                'transliteracao' => 'aretḗ',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'destaque'       => true,
                'ordem'          => 2,
                'imagem'         => 'https://images.unsplash.com/photo-1564660677770-7eea29ce4e3a?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'Excelência. A realização plena daquilo que algo é por natureza — a faca corta bem, o cavalo corre bem, o homem vive bem.',
                    'en'    => 'Excellence. The full realisation of what something is by nature — a knife cuts well, a horse runs well, a man lives well.',
                ],
                'descricao' => [
                    'pt_BR' => "Traduzir aretḗ por \"virtude\" é empobrecer o termo. Para um grego, é antes a excelência funcional: o cavalo veloz tem aretḗ de cavalo; o cidadão justo tem aretḗ de cidadão. Aristóteles dedica os dez livros da Ética a Nicómaco a perguntar qual é a aretḗ própria do ser humano — e responde: a vida segundo o lógos.",
                ],
                'etimologia' => [
                    'pt_BR' => 'De ἄριστος (áristos), "o melhor", superlativo de uma raiz indo-europeia que também dá em latim virtus.',
                ],
                'citacao_classica' => [
                    'pt_BR' => 'ἡ ἀρετὴ τοῦ ἀνθρώπου ψυχῆς ἕξις ἂν εἴη.',
                ],
                'citacao_autor' => ['pt_BR' => 'Aristóteles, Ética a Nicómaco, II'],
            ],

            [
                'slug'           => 'kairos',
                'termo'          => 'Καιρός',
                'transliteracao' => 'kairós',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'ordem'          => 3,
                'imagem'         => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'O momento oportuno. Não o tempo que mede o relógio (χρόνος), mas o instante decisivo em que algo deve ser feito.',
                ],
                'descricao' => [
                    'pt_BR' => "Os gregos tinham dois tempos: chrónos, o tempo quantitativo que passa, e kairós, o tempo qualitativo que se aproveita. Um arqueiro experimenta o kairós quando lança a flecha; um orador, quando interrompe o silêncio; um médico, quando administra o remédio. Não é o relógio que decide o kairós — é o juízo.",
                ],
                'etimologia' => [
                    'pt_BR' => 'Originalmente, ponto crítico — a abertura precisa entre os fios do tear por onde passa a lançadeira.',
                ],
                'citacao_classica' => [
                    'pt_BR' => 'πάντα καιρὸν ἔχει.',
                ],
                'citacao_autor' => ['pt_BR' => 'Eclesiastes 3,1 (LXX)'],
            ],

            [
                'slug'           => 'sophia',
                'termo'          => 'Σοφία',
                'transliteracao' => 'sophía',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'ordem'          => 4,
                'imagem'         => 'https://images.unsplash.com/photo-1532153975070-2e9ab71f1b14?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'Sabedoria. O conhecimento dos princípios mais altos — o que filó-sofo significa: aquele que ama a sophía.',
                ],
                'descricao' => [
                    'pt_BR' => "Em Aristóteles, sophía é o ápice das virtudes intelectuais: o conhecimento dos primeiros princípios unido à ciência das consequências. Tem irmãs práticas — φρόνησις (prudência) e τέχνη (arte) — mas é a única que contempla o que é eterno.",
                ],
                'etimologia' => [
                    'pt_BR' => 'Raiz incerta; possivelmente ligada a σαφής (saphḗs), "claro, manifesto".',
                ],
            ],

            [
                'slug'           => 'mythos',
                'termo'          => 'Μῦθος',
                'transliteracao' => 'mýthos',
                'lingua'         => 'el',
                'categoria'      => 'Literatura',
                'ordem'          => 5,
                'imagem'         => 'https://images.unsplash.com/photo-1555993539-1732b0258235?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'Narrativa, palavra contada. Antes de Platão, mýthos e lógos eram quase sinónimos — ambos diziam discurso.',
                ],
                'descricao' => [
                    'pt_BR' => "Foi Platão quem opôs mýthos a lógos: a história contada à demonstração racional. Mas há ironia nessa oposição — o próprio Platão recorre constantemente a mitos (o mito da caverna, o mito de Er) quando o argumento já não basta. O mito não é o oposto da verdade: é uma forma de a tocar onde a prova não chega.",
                ],
            ],

            [
                'slug'           => 'emet',
                'termo'          => 'אֱמֶת',
                'transliteracao' => 'ʾemet',
                'lingua'         => 'he',
                'categoria'      => 'Bíblico',
                'destaque'       => true,
                'ordem'          => 6,
                'imagem'         => 'https://images.unsplash.com/photo-1544413164-5f1b295eb435?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'Verdade. Mas não a verdade lógica grega — a verdade hebraica é fidelidade: aquilo em que se pode confiar.',
                ],
                'descricao' => [
                    'pt_BR' => "Há um detalhe sublime: ʾemet é composta da primeira (א), do meio (מ) e da última letra (ת) do alefato. Os rabinos viam aí a totalidade. Tirar o alef e fica מֵת (met) — \"morto\". A tradição mística diz: onde falta a verdade, o que sobra é morte.",
                ],
                'etimologia' => [
                    'pt_BR' => 'Da raiz אמן (ʾ-m-n), que dá também אמונה (fé, fidelidade) e o nosso amém.',
                ],
                'citacao_classica' => [
                    'pt_BR' => 'הָאֱלֹהִים אֱמֶת — "Deus é verdade."',
                ],
                'citacao_autor' => ['pt_BR' => 'Jeremias 10,10'],
            ],

            [
                'slug'           => 'shalom',
                'termo'          => 'שָׁלוֹם',
                'transliteracao' => 'shalom',
                'lingua'         => 'he',
                'categoria'      => 'Bíblico',
                'destaque'       => true,
                'ordem'          => 7,
                'imagem'         => 'https://images.unsplash.com/photo-1551506448-074afa034c05?auto=format&fit=crop&w=1200&q=85',
                'significado' => [
                    'pt_BR' => 'Paz. Mas muito mais que ausência de guerra: é plenitude, integridade, harmonia restaurada entre todas as partes.',
                ],
                'descricao' => [
                    'pt_BR' => "Para um hebreu antigo, shalom é o estado de quem nada falta — relação justa com Deus, com os outros e consigo. Por isso shalom serve para cumprimentar (entrar bem) e para despedir (sair bem). É a saúde da alma e do corpo numa palavra só.",
                ],
                'etimologia' => [
                    'pt_BR' => 'Da raiz שלם (sh-l-m), "estar completo, íntegro". Cognato de Salomão (o pacífico).',
                ],
            ],

            [
                'slug'           => 'chesed',
                'termo'          => 'חֶסֶד',
                'transliteracao' => 'ḥesed',
                'lingua'         => 'he',
                'categoria'      => 'Bíblico',
                'ordem'          => 8,
                'significado' => [
                    'pt_BR' => 'Amor leal. O afeto fiel que ultrapassa a obrigação — uma das palavras mais difíceis de traduzir do hebraico bíblico.',
                ],
                'descricao' => [
                    'pt_BR' => "Os tradutores antigos hesitaram entre \"misericórdia\", \"benevolência\", \"graça\". Nenhum termo capta o que ḥesed faz: é o amor da aliança, o que continua a amar quando já não tinha de o fazer. É o que Boaz mostra por Rute, o que Davi recebe de Jónatas, o que Deus promete ao seu povo.",
                ],
            ],

            [
                'slug'           => 'davar',
                'termo'          => 'דָּבָר',
                'transliteracao' => 'davar',
                'lingua'         => 'he',
                'categoria'      => 'Bíblico',
                'ordem'          => 9,
                'significado' => [
                    'pt_BR' => 'Palavra e coisa ao mesmo tempo. Em hebraico, dizer e fazer estão na mesma raiz.',
                ],
                'descricao' => [
                    'pt_BR' => "Davar é simultaneamente \"palavra\" e \"acontecimento\". Quando Deus fala em Génesis, basta dizer e a coisa existe — porque em hebraico a palavra é já realidade. Esta unidade entre logos e ergon (palavra e ato) é uma das chaves para se entender a Bíblia hebraica.",
                ],
            ],

            [
                'slug'           => 'pneuma',
                'termo'          => 'Πνεῦμα',
                'transliteracao' => 'pneûma',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'ordem'          => 10,
                'significado' => [
                    'pt_BR' => 'Sopro, vento, espírito. A mesma palavra que designa o ar em movimento designa também a alma.',
                ],
                'descricao' => [
                    'pt_BR' => "Tradução grega do hebraico ruaḥ, pneûma carrega os três sentidos: o vento físico, o sopro vital e o espírito. Há filosofia inteira nisto: para os antigos, viver é ser atravessado por um sopro que vem de fora. Daí pneumático (relativo ao ar), pneumonia (inflamação dos pulmões) e Espírito Santo (Pneûma Hágion).",
                ],
            ],

            [
                'slug'           => 'philia',
                'termo'          => 'Φιλία',
                'transliteracao' => 'philía',
                'lingua'         => 'el',
                'categoria'      => 'Filosofia',
                'ordem'          => 11,
                'significado' => [
                    'pt_BR' => 'Amizade. Para Aristóteles, uma das condições da vida boa — sem amigos, ninguém escolheria viver, ainda que tivesse todos os outros bens.',
                ],
                'descricao' => [
                    'pt_BR' => "Os gregos tinham quatro palavras para o que nós chamamos amor: érōs (paixão), storgḗ (afeto familiar), agápē (amor de aliança) e philía (amizade). A philía é a única que escolhemos livremente e que se constrói no tempo — daí ser, para Aristóteles, a forma mais alta.",
                ],
            ],

            [
                'slug'           => 'paideia',
                'termo'          => 'Παιδεία',
                'transliteracao' => 'paideía',
                'lingua'         => 'el',
                'categoria'      => 'Educação',
                'ordem'          => 12,
                'significado' => [
                    'pt_BR' => 'Formação integral. Não só ensino: a moldagem de um ser humano completo — intelectual, moral, estética, física.',
                ],
                'descricao' => [
                    'pt_BR' => "O Gramma nasceu desta palavra. Paideía é mais do que educação: é o processo pelo qual uma criança (paîs) se torna um ser humano completo. Implica ler os poetas, exercitar o corpo, aprender música, contemplar a justiça. Werner Jaeger escreveu três volumes sobre ela. Nós tentamos viver dela.",
                ],
            ],
        ];

        foreach ($terms as $term) {
            GlossaryTerm::updateOrCreate(['slug' => $term['slug']], $term);
        }
    }
}
