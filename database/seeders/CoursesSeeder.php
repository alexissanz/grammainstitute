<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            // ──────────────────────────────────────────────────────────────
            'grego' => [
                'codigo'        => 'el',
                'glifo'         => 'Ελ',
                'cor_destaque'  => '#7e5223',
                'imagem_capa'   => 'https://images.unsplash.com/photo-1555993539-1732b0258235?auto=format&fit=crop&w=1600&q=85',
                'imagem_fundo'  => 'https://images.unsplash.com/photo-1564660677770-7eea29ce4e3a?auto=format&fit=crop&w=2400&q=85',
                'professor_nome' => 'Dr. Aléxios Konstantínou',
                'professor_foto' => 'https://images.unsplash.com/photo-1559548331-f9cb98001426?auto=format&fit=crop&w=600&q=85',
                'duracao_total' => '180h · 9 módulos',
                'formato'       => 'Online ao vivo · Híbrido em São Paulo',
                'preco'         => 'A partir de R$ 380 / mês',
                'vagas_por_turma' => 8,
                'destaque'      => true,
                'contato_whatsapp' => '+5511999998888',
                'contato_email' => 'grego@grammainstitute.com',
                'ordem' => 1,
                'nome' => [
                    'pt_BR' => 'Grego Clássico & Koiné',
                    'en'    => 'Classical & Koine Greek',
                    'es'    => 'Griego Clásico y Koiné',
                    'he'    => 'יוונית קלאסית וקוֹינֶה',
                    'el'    => 'Κλασσική καὶ Κοινὴ Ἑλληνική',
                ],
                'subtitulo' => [
                    'pt_BR' => 'A língua de Homero, Platão e do Novo Testamento',
                    'en'    => 'The language of Homer, Plato and the New Testament',
                    'es'    => 'La lengua de Homero, Platón y del Nuevo Testamento',
                    'he'    => 'שפת הומרוס, אפלטון והברית החדשה',
                    'el'    => 'Ἡ γλῶσσα τοῦ Ὁμήρου, τοῦ Πλάτωνος καὶ τῆς Καινῆς Διαθήκης',
                ],
                'descricao_curta' => [
                    'pt_BR' => 'Um percurso de filólogos para quem deseja ler os clássicos no original.',
                    'en'    => "A philologist's path for those who wish to read the classics in the original.",
                ],
                'descricao_longa' => [
                    'pt_BR' => "Estudar grego é entrar na sala em que o pensamento ocidental foi escrito. Neste curso percorremos do alfabeto à leitura corrida de Heródoto e do Evangelho de João, sempre com texto autêntico em mãos. Nossa abordagem une o rigor da gramática histórico-comparativa à prática de leitura comentada, em pequenas turmas onde cada aluno traduz e discute.",
                    'en'    => "To study Greek is to enter the room where Western thought was first written down. From the alphabet to fluent reading of Herodotus and the Gospel of John, this course pairs rigorous historical-comparative grammar with guided reading of authentic texts in small, conversation-heavy seminars.",
                ],
                'historia_lingua' => [
                    'pt_BR' => "O grego é a língua europeia continuamente atestada há mais tempo: mais de 34 séculos. Do micênico das tabuinhas de Linear B ao demótico contemporâneo, passou por Homero, pelos diálogos socráticos, pela tradução dos Setenta, pelos Padres da Igreja e por Bizâncio. Cada estrato deixou marcas — e cada texto pede uma chave diferente.",
                    'en'    => "Greek is the longest continuously attested European language — more than 34 centuries. From Mycenaean Linear B tablets to contemporary Demotic, it passed through Homer, the Socratic dialogues, the Septuagint, the Church Fathers and Byzantium. Each stratum left its mark, and each text demands its own key.",
                ],
                'alfabeto_info' => [
                    'pt_BR' => "24 letras, três acentos, dois espíritos. Estudamos a pronúncia restituta (Erasmiana) e a pronúncia moderna lado a lado, para que o aluno transite entre Platão e a Atenas de hoje.",
                    'en'    => "24 letters, three accents, two breathings. We teach restored (Erasmian) and Modern Greek pronunciation side by side, so students can move between Plato and modern-day Athens.",
                ],
                'para_quem' => [
                    'pt_BR' => "Filósofos, teólogos, biblistas, historiadores, classicistas, advogados que lidam com etimologia jurídica e, sobretudo, leitores curiosos. Não exigimos conhecimento prévio.",
                    'en'    => "Philosophers, theologians, biblical scholars, historians, classicists, and curious readers. No prior knowledge required.",
                ],
                'o_que_aprende' => [
                    'pt_BR' => [
                        'Alfabeto, acentuação e fonética restituta',
                        'Sistema nominal e verbal do grego clássico',
                        'Leitura comentada de Platão, Xenofonte e dos Evangelhos',
                        'Sintaxe das orações subordinadas (final, consecutiva, condicional)',
                        'Versão direta e inversa em pequenos trechos',
                        'Análise de variantes textuais e crítica textual aplicada',
                    ],
                    'en' => [
                        'Alphabet, accents and restored phonetics',
                        'Classical Greek nominal and verbal systems',
                        'Guided reading of Plato, Xenophon and the Gospels',
                        'Subordinate clause syntax (final, consecutive, conditional)',
                        'Translation drills, both directions',
                        'Manuscript variants and applied textual criticism',
                    ],
                ],
                'niveis' => [
                    [
                        'nome' => ['pt_BR' => 'Iniciante (Α)', 'en' => 'Beginner (Α)'],
                        'descricao' => ['pt_BR' => 'Alfabeto, declinações regulares, verbo no presente. Leituras simples de Xenofonte.', 'en' => 'Alphabet, regular declensions, present tense. Easy Xenophon readings.'],
                        'duracao' => '60h',
                    ],
                    [
                        'nome' => ['pt_BR' => 'Intermediário (Β)', 'en' => 'Intermediate (Β)'],
                        'descricao' => ['pt_BR' => 'Aoristos, particípios, infinitivos. Diálogos platónicos curtos.', 'en' => 'Aorist tenses, participles, infinitives. Short Platonic dialogues.'],
                        'duracao' => '60h',
                    ],
                    [
                        'nome' => ['pt_BR' => 'Avançado (Γ)', 'en' => 'Advanced (Γ)'],
                        'descricao' => ['pt_BR' => 'Verbos atemáticos, dialetos, leitura corrida de Heródoto e João.', 'en' => 'Athematic verbs, dialects, fluent reading of Herodotus and John.'],
                        'duracao' => '60h',
                    ],
                ],
                'professor_bio' => [
                    'pt_BR' => "Doutorado em Estudos Helénicos pela Universidade de Atenas, com passagem pela École Pratique des Hautes Études. Vinte anos de ensino do grego em três continentes. Tradutor de Píndaro para o português.",
                    'en'    => "PhD in Hellenic Studies from the University of Athens, with research stays at the École Pratique des Hautes Études. Twenty years teaching Greek across three continents. Translator of Pindar into Portuguese.",
                ],
                'professor_titulos' => [
                    'pt_BR' => 'PhD · Universidade de Atenas',
                    'en'    => 'PhD · University of Athens',
                ],
            ],

            // ──────────────────────────────────────────────────────────────
            'hebraico' => [
                'codigo'        => 'he',
                'glifo'         => 'אב',
                'cor_destaque'  => '#6c1f1f',
                'imagem_capa'   => 'https://images.unsplash.com/photo-1544413164-5f1b295eb435?auto=format&fit=crop&w=1600&q=85',
                'imagem_fundo'  => 'https://images.unsplash.com/photo-1551506448-074afa034c05?auto=format&fit=crop&w=2400&q=85',
                'professor_nome' => 'Dra. Yael Ben-Ami',
                'professor_foto' => 'https://images.unsplash.com/photo-1573497019418-b400bb3ab074?auto=format&fit=crop&w=600&q=85',
                'duracao_total' => '160h · 8 módulos',
                'formato'       => 'Online ao vivo · Materiais com áudio nativo',
                'preco'         => 'A partir de R$ 360 / mês',
                'vagas_por_turma' => 8,
                'destaque'      => true,
                'contato_whatsapp' => '+5511999998888',
                'contato_email' => 'hebraico@grammainstitute.com',
                'ordem' => 2,
                'nome' => [
                    'pt_BR' => 'Hebraico Bíblico & Moderno',
                    'en'    => 'Biblical & Modern Hebrew',
                    'es'    => 'Hebreo Bíblico y Moderno',
                    'he'    => 'עברית מקראית ועברית מודרנית',
                    'el'    => 'Ἑβραϊκὴ Βιβλικὴ καὶ Σύγχρονη',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Da Torá às ruas de Tel Aviv',
                    'en'    => 'From the Torah to the streets of Tel Aviv',
                ],
                'descricao_curta' => [
                    'pt_BR' => 'Duas eras da mesma língua sagrada, ensinadas com rigor filológico e fluência conversacional.',
                    'en'    => 'Two eras of the same sacred language, taught with philological rigour and conversational fluency.',
                ],
                'descricao_longa' => [
                    'pt_BR' => "O hebraico é uma das raras línguas que renasceu. Aprendemos a ler Génesis no original e, simultaneamente, a pedir um café em Jerusalém. As aulas alternam texto bíblico vocalizado e diálogos modernos, num percurso que respeita a continuidade entre o sagrado e o quotidiano.",
                    'en'    => "Hebrew is one of the few languages that has been reborn. We learn to read Genesis in the original while, at the same time, ordering coffee in Jerusalem. Classes alternate vocalised biblical text and modern dialogues — a path that honours the continuity between the sacred and the everyday.",
                ],
                'historia_lingua' => [
                    'pt_BR' => "Da inscrição de Siloé (séc. VIII a.C.) à reanimação por Eliezer Ben-Yehuda em finais do século XIX, o hebraico atravessou silêncios de quase dois milénios sem nunca desaparecer da liturgia. Hoje é língua materna de mais de cinco milhões de pessoas — caso único na história.",
                    'en'    => "From the Siloam inscription (8th century BC) to Eliezer Ben-Yehuda's revival in the late 19th century, Hebrew survived nearly two thousand years of liturgical use before becoming again the mother tongue of more than five million speakers — a unique case in human history.",
                ],
                'alfabeto_info' => [
                    'pt_BR' => "22 consoantes, escrita da direita para a esquerda, vocalização massorética opcional. Estudamos o alefato com sua história — letras que foram também números e símbolos místicos.",
                    'en'    => "22 consonants, written right to left, with optional Masoretic vocalisation. We study the Aleph-Bet alongside its history — letters that were once also numerals and mystical symbols.",
                ],
                'para_quem' => [
                    'pt_BR' => "Estudantes da Bíblia, rabinos em formação, pesquisadores do Antigo Oriente, viajantes de Israel e curiosos da Cabala.",
                    'en'    => "Bible students, rabbinical candidates, ancient Near East researchers, travellers to Israel and Kabbalah enthusiasts.",
                ],
                'o_que_aprende' => [
                    'pt_BR' => [
                        'Alefato e vocalização massorética',
                        'Sistema verbal hebraico (binyanim)',
                        'Leitura cursiva do livro de Génesis',
                        'Conversação moderna nível A1–B1',
                        'Cantilação básica e leitura litúrgica',
                        'Raízes triliterais e formação lexical',
                    ],
                ],
                'niveis' => [
                    [
                        'nome' => ['pt_BR' => 'Aleph (א)', 'en' => 'Aleph (א)'],
                        'descricao' => ['pt_BR' => 'Alefato, vocalização, frases simples.', 'en' => 'Aleph-Bet, vowels, simple sentences.'],
                        'duracao' => '50h',
                    ],
                    [
                        'nome' => ['pt_BR' => 'Bet (ב)', 'en' => 'Bet (ב)'],
                        'descricao' => ['pt_BR' => 'Verbos binyanim, narrativa bíblica curta.', 'en' => 'Binyan verbs, short biblical narrative.'],
                        'duracao' => '55h',
                    ],
                    [
                        'nome' => ['pt_BR' => 'Gimel (ג)', 'en' => 'Gimel (ג)'],
                        'descricao' => ['pt_BR' => 'Leitura corrida de Génesis, conversação fluente.', 'en' => 'Fluent reading of Genesis, conversation.'],
                        'duracao' => '55h',
                    ],
                ],
                'professor_bio' => [
                    'pt_BR' => "Doutorada em Bíblia Hebraica pela Universidade Hebraica de Jerusalém. Pesquisa em manuscritos do Mar Morto e didática do hebraico para falantes de português.",
                    'en'    => "PhD in Hebrew Bible from the Hebrew University of Jerusalem. Research on Dead Sea Scrolls and Hebrew pedagogy for Portuguese speakers.",
                ],
                'professor_titulos' => ['pt_BR' => 'PhD · Universidade Hebraica de Jerusalém'],
            ],

            // ──────────────────────────────────────────────────────────────
            'ingles' => [
                'codigo'        => 'en',
                'glifo'         => 'En',
                'cor_destaque'  => '#1a3a5c',
                'imagem_capa'   => 'https://images.unsplash.com/photo-1486299267070-83823f5448dd?auto=format&fit=crop&w=1600&q=85',
                'imagem_fundo'  => 'https://images.unsplash.com/photo-1543872084-c7bd3822856f?auto=format&fit=crop&w=2400&q=85',
                'professor_nome' => 'Prof. Edmund Hartwell',
                'professor_foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=85',
                'duracao_total' => '120h · 6 módulos',
                'formato'       => 'Online · Presencial · Híbrido',
                'preco'         => 'A partir de R$ 290 / mês',
                'vagas_por_turma' => 10,
                'contato_whatsapp' => '+5511999998888',
                'contato_email' => 'english@grammainstitute.com',
                'ordem' => 3,
                'nome' => [
                    'pt_BR' => 'Inglês — Tradição e Conversação',
                    'en'    => 'English — Tradition and Conversation',
                ],
                'subtitulo' => [
                    'pt_BR' => 'De Shakespeare ao boardroom — o inglês que se lê e se vive',
                    'en'    => 'From Shakespeare to the boardroom — English read and lived',
                ],
                'descricao_curta' => [
                    'pt_BR' => 'Conversação fluente com a profundidade de quem leu os clássicos.',
                    'en'    => 'Fluent conversation with the depth of someone who has read the classics.',
                ],
                'descricao_longa' => [
                    'pt_BR' => "Cansado de cursos que tratam o inglês como software? Nós ensinamos a língua de Shakespeare, Dickens e Toni Morrison como ela merece — com texto literário, debate, prática conversacional e atenção fina à pronúncia. Ao fim do percurso, o aluno conversa com naturalidade e lê o que outras pessoas só ouvem dizer.",
                    'en'    => "Tired of courses that treat English as software? We teach the language of Shakespeare, Dickens and Toni Morrison as it deserves — with literary texts, debate, conversation practice and fine attention to pronunciation. By the end, students converse with ease and read what others only hear talked about.",
                ],
                'historia_lingua' => [
                    'pt_BR' => "Língua germânica trazida pelos anglos para a Britânia no século V, transformada pelo francês normando no século XI e pelo Renascimento no XVI. Hoje é a língua materna de cerca de 380 milhões e a segunda língua de outros 1.500 milhões.",
                    'en'    => "A Germanic language brought to Britain by the Angles in the 5th century, transformed by Norman French in the 11th and by the Renaissance in the 16th. Today it is the mother tongue of about 380 million and a second language of another 1.5 billion.",
                ],
                'alfabeto_info' => [
                    'pt_BR' => "26 letras, ortografia profundamente irregular — herança das suas múltiplas camadas históricas. Estudamos a fonética com transcrição IPA, porque saber escrever não basta para saber dizer.",
                ],
                'para_quem' => [
                    'pt_BR' => "Profissionais, estudantes universitários, candidatos a testes (TOEFL/IELTS/Cambridge) e leitores que querem encontrar Hemingway sem intermediário.",
                ],
                'o_que_aprende' => [
                    'pt_BR' => [
                        'Conversação em níveis A1 a C1',
                        'Pronúncia britânica e americana com IPA',
                        'Inglês para negócios e apresentações',
                        'Leitura de prosa literária moderna',
                        'Escrita académica e profissional',
                        'Preparação para TOEFL / IELTS / Cambridge',
                    ],
                ],
                'niveis' => [
                    ['nome' => ['pt_BR'=>'A1–A2 Foundation'], 'descricao' => ['pt_BR'=>'Estruturas básicas, presente, passado, conversação simples.'], 'duracao' => '30h'],
                    ['nome' => ['pt_BR'=>'B1–B2 Conversational'], 'descricao' => ['pt_BR'=>'Tempos compostos, opiniões, debate, redação.'], 'duracao' => '45h'],
                    ['nome' => ['pt_BR'=>'C1 Advanced & Literary'], 'descricao' => ['pt_BR'=>'Idioms, prosa literária, escrita académica.'], 'duracao' => '45h'],
                ],
                'professor_bio' => [
                    'pt_BR' => "Britânico, mestre em Linguística Aplicada por Oxford. Quinze anos de ensino do inglês em Lisboa, São Paulo e Berlim. Apaixonado pelo Tennyson e pelos romances de Iris Murdoch.",
                ],
                'professor_titulos' => ['pt_BR' => 'MA · University of Oxford'],
            ],

            // ──────────────────────────────────────────────────────────────
            'espanhol' => [
                'codigo'        => 'es',
                'glifo'         => 'Es',
                'cor_destaque'  => '#a87841',
                'imagem_capa'   => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325?auto=format&fit=crop&w=1600&q=85',
                'imagem_fundo'  => 'https://images.unsplash.com/photo-1574260031597-bfdaad79c014?auto=format&fit=crop&w=2400&q=85',
                'professor_nome' => 'Prof. Carmen Aldecoa',
                'professor_foto' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=85',
                'duracao_total' => '120h · 6 módulos',
                'formato'       => 'Online · Presencial',
                'preco'         => 'A partir de R$ 270 / mês',
                'vagas_por_turma' => 10,
                'contato_whatsapp' => '+5511999998888',
                'contato_email' => 'espanol@grammainstitute.com',
                'ordem' => 4,
                'nome' => [
                    'pt_BR' => 'Espanhol — Península e Américas',
                    'en'    => 'Spanish — Peninsula and the Americas',
                    'es'    => 'Español — Península y Américas',
                ],
                'subtitulo' => [
                    'pt_BR' => 'Cervantes, Borges, García Márquez — uma língua, muitas vozes',
                    'es'    => 'Cervantes, Borges, García Márquez — una lengua, muchas voces',
                ],
                'descricao_curta' => [
                    'pt_BR' => 'O espanhol em todas as suas variantes — castelhano, rio-platense, mexicano, andino.',
                    'es'    => 'El español en todas sus variantes — castellano, rioplatense, mexicano, andino.',
                ],
                'descricao_longa' => [
                    'pt_BR' => "Falar espanhol não é falar a língua de um país, mas de um continente. Trabalhamos a fonologia castelhana e a entonação porteña, lemos Cervantes na sua originalidade barroca e Borges na sua precisão cortante. Os professores são falantes nativos de Espanha, Argentina e México — para que o seu ouvido reconheça o mundo hispânico inteiro.",
                ],
                'historia_lingua' => [
                    'pt_BR' => "Filha do latim vulgar levado à Hispânia romana e atravessada por oito séculos de presença árabe, a língua castelhana cristalizou-se na corte de Toledo no século XIII. Hoje é falada por mais de 580 milhões de pessoas em 21 países.",
                ],
                'alfabeto_info' => [
                    'pt_BR' => "27 letras (com o ñ característico). Estudamos as três grandes zonas de pronúncia: peninsular, rio-platense e mexicana.",
                ],
                'para_quem' => [
                    'pt_BR' => "Brasileiros que querem ir além do portunhol, profissionais que negociam com a América Hispânica, leitores de literatura hispano-americana e amantes do flamenco e do tango.",
                ],
                'o_que_aprende' => [
                    'pt_BR' => [
                        'Pronúncia castelhana e rio-platense',
                        'Subjuntivo, condicionais e ser/estar (o terror dos brasileiros)',
                        'Leitura de El Quijote (excertos)',
                        'Conversação em situações reais',
                        'Variantes lexicais: che, ahorita, vale',
                        'Literatura latino-americana contemporânea',
                    ],
                ],
                'niveis' => [
                    ['nome' => ['pt_BR'=>'A1–A2'], 'descricao' => ['pt_BR'=>'Presente, pretérito, descrição.'], 'duracao' => '30h'],
                    ['nome' => ['pt_BR'=>'B1–B2'], 'descricao' => ['pt_BR'=>'Subjuntivo, condicionais, debate.'], 'duracao' => '45h'],
                    ['nome' => ['pt_BR'=>'C1 Literário'], 'descricao' => ['pt_BR'=>'El Quijote, Borges, García Márquez.'], 'duracao' => '45h'],
                ],
                'professor_bio' => [
                    'pt_BR' => "Madrilenha, doutorada em Filologia Hispânica pela Universidad Complutense. Pesquisa em literatura áurea e didática do espanhol como L2.",
                ],
                'professor_titulos' => ['pt_BR' => 'PhD · Universidad Complutense de Madrid'],
            ],

            // ──────────────────────────────────────────────────────────────
            'portugues' => [
                'codigo'        => 'pt_BR',
                'glifo'         => 'Pt',
                'cor_destaque'  => '#4f5b35',
                'imagem_capa'   => 'https://images.unsplash.com/photo-1543872084-c7bd3822856f?auto=format&fit=crop&w=1600&q=85',
                'imagem_fundo'  => 'https://images.unsplash.com/photo-1483347756197-71ef80e95f73?auto=format&fit=crop&w=2400&q=85',
                'professor_nome' => 'Prof. Helena Vasconcelos',
                'professor_foto' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=85',
                'duracao_total' => '120h · 6 módulos',
                'formato'       => 'Online · Imersão presencial em São Paulo',
                'preco'         => 'A partir de R$ 320 / mês',
                'vagas_por_turma' => 8,
                'contato_whatsapp' => '+5511999998888',
                'contato_email' => 'portugues@grammainstitute.com',
                'ordem' => 5,
                'nome' => [
                    'pt_BR' => 'Português para Estrangeiros (PLE)',
                    'en'    => 'Portuguese for Foreigners (PFL)',
                ],
                'subtitulo' => [
                    'pt_BR' => 'A língua de Pessoa, Saramago e Machado de Assis',
                    'en'    => 'The language of Pessoa, Saramago and Machado de Assis',
                ],
                'descricao_curta' => [
                    'pt_BR' => 'Aprender português é entrar em três continentes ao mesmo tempo.',
                    'en'    => 'Learning Portuguese is entering three continents at once.',
                ],
                'descricao_longa' => [
                    'pt_BR' => "Não somos um curso técnico de português. Somos uma escola onde estrangeiros descobrem por que Pessoa escreveu \"a minha pátria é a língua portuguesa\". Estudamos as duas grandes normas — europeia e brasileira — sem hierarquia, com falantes nativos de ambos os lados do Atlântico.",
                    'en'    => "We are not a technical Portuguese school. We are a place where foreigners discover why Pessoa wrote \"my homeland is the Portuguese language.\" We teach both the European and Brazilian norms — without hierarchy — with native speakers from both sides of the Atlantic.",
                ],
                'historia_lingua' => [
                    'pt_BR' => "Língua românica formada no condado portucalense no século XII, levada por navegadores a quatro continentes. Hoje é a sexta língua mais falada do mundo, com mais de 260 milhões de falantes — e a única que diz saudade.",
                ],
                'alfabeto_info' => [
                    'pt_BR' => "26 letras com til e cedilha. Ensinamos a fonética europeia e a brasileira lado a lado, com áudios nativos de Lisboa, Porto, Rio e Salvador.",
                ],
                'para_quem' => [
                    'pt_BR' => "Estrangeiros que vivem ou querem viver em país lusófono, leitores de Pessoa, pesquisadores de literatura comparada e descendentes que querem reencontrar a língua dos avós.",
                ],
                'o_que_aprende' => [
                    'pt_BR' => [
                        'Pronúncia europeia vs. brasileira',
                        'Conjugação verbal completa (com o futuro do subjuntivo)',
                        'Leitura de Pessoa, Saramago e Machado',
                        'Português jurídico e académico',
                        'Variantes africanas (Angola, Moçambique)',
                        'Cultura e referências literárias',
                    ],
                ],
                'niveis' => [
                    ['nome' => ['pt_BR'=>'A1–A2 Sobrevivência'], 'descricao' => ['pt_BR'=>'Pronúncia, presente, passados, conversação básica.'], 'duracao' => '30h'],
                    ['nome' => ['pt_BR'=>'B1–B2 Conversacional'], 'descricao' => ['pt_BR'=>'Subjuntivo, infinitivo pessoal, debate.'], 'duracao' => '45h'],
                    ['nome' => ['pt_BR'=>'C1 Literário'], 'descricao' => ['pt_BR'=>'Pessoa, Saramago, prosa machadiana.'], 'duracao' => '45h'],
                ],
                'professor_bio' => [
                    'pt_BR' => "Lisboeta de nascimento, paulistana de adoção. Doutorada em Literatura Portuguesa pela Universidade de Coimbra. Tradutora de poesia barroca.",
                ],
                'professor_titulos' => ['pt_BR' => 'PhD · Universidade de Coimbra'],
            ],
        ];

        foreach ($courses as $slug => $data) {
            Course::updateOrCreate(['slug' => $slug], $data);
        }
    }
}
