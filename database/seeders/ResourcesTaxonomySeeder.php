<?php

namespace Database\Seeders;

use App\Models\ResourceCategory;
use App\Models\ResourceLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ResourcesTaxonomySeeder extends Seeder
{
    /**
     * Rebuilds the Resources tree exactly as specified:
     * Area (category) -> Section (grupo) -> Tools (links).
     * URLs filled in for the well-known sites; "#" placeholders for the rest,
     * to be completed later in the admin panel.
     */
    public function run(): void
    {
        // Wipe existing tree (links cascade on category delete).
        Schema::disableForeignKeyConstraints();
        ResourceLink::query()->delete();
        ResourceCategory::query()->delete();
        Schema::enableForeignKeyConstraints();

        $tree = $this->tree();

        $catOrder = 0;
        foreach ($tree as $cat) {
            $category = ResourceCategory::create([
                'slug'        => $cat['slug'],
                'title'       => ['en' => $cat['title']],
                'description' => [],
                'icon'        => $cat['icon'],
                'ordem'       => $catOrder++,
                'ativo'       => true,
            ]);

            $linkOrder  = 0;
            $grupoOrder = 0;
            foreach ($cat['sections'] as $section) {
                $grupo = $section['grupo']; // may be null (flat list)
                foreach ($section['links'] as [$name, $url]) {
                    ResourceLink::create([
                        'category_id' => $category->id,
                        'grupo'       => $grupo,
                        'grupo_ordem' => $grupoOrder,
                        'title'       => ['en' => $name],
                        'description' => [],
                        'url'         => $url,
                        'ordem'       => $linkOrder++,
                        'ativo'       => true,
                    ]);
                }
                $grupoOrder++;
            }
        }
    }

    private function tree(): array
    {
        return [
            // ===================== BIBLICAL HEBREW =====================
            [
                'slug' => 'biblical-hebrew', 'title' => 'Biblical Hebrew', 'icon' => 'fa-scroll',
                'sections' => [
                    ['grupo' => 'Alphabet and Pronunciation', 'links' => [
                        ['Hebrew for Christians', 'https://www.hebrew4christians.com'],
                        ['Aleph with Beth', '#'],
                        ['Free Hebrew Forever', '#'],
                    ]],
                    ['grupo' => 'Reading Practice', 'links' => [
                        ['Mechon Mamre', 'https://www.mechon-mamre.org'],
                        ['Tanach.us', 'https://www.tanach.us'],
                    ]],
                    ['grupo' => 'Beginner Grammar', 'links' => [
                        ['BiblicalHebrew.com', 'https://www.biblicalhebrew.com'],
                        ['BYU Biblical Hebrew Suite', '#'],
                        ['All-in-One Biblical Hebrew', '#'],
                    ]],
                    ['grupo' => 'Intermediate Hebrew', 'links' => [
                        ['Daily Dose of Hebrew', 'https://dailydoseofhebrew.com'],
                        ['Open Scriptures Hebrew Bible', 'https://hb.openscriptures.org'],
                    ]],
                    ['grupo' => 'Hebrew Bible Tools', 'links' => [
                        ['STEP Bible', 'https://www.stepbible.org'],
                        ['Bible Hub', 'https://biblehub.com'],
                        ['Blue Letter Bible', 'https://www.blueletterbible.org'],
                    ]],
                    ['grupo' => 'Advanced Hebrew', 'links' => [
                        ['Brown-Driver-Briggs Lexicon', '#'],
                        ['Gesenius Hebrew Grammar', '#'],
                        ['ETCBC Hebrew Database', '#'],
                        ['Sefaria', 'https://www.sefaria.org'],
                        ['JTS Biblical Hebrew', '#'],
                        ['Bible Project Hebrew Bible Course', 'https://bibleproject.com'],
                    ]],
                ],
            ],

            // ===================== KOINE GREEK =====================
            [
                'slug' => 'koine-greek', 'title' => 'Koine Greek', 'icon' => 'fa-language',
                'sections' => [
                    ['grupo' => 'Alphabet and Pronunciation', 'links' => [
                        ['Bill Mounce Greek', 'https://www.billmounce.com'],
                        ['Free Greek Online', '#'],
                        ['Alpha with Angela', '#'],
                    ]],
                    ['grupo' => 'Beginner Grammar', 'links' => [
                        ['Basics of Biblical Greek', '#'],
                        ['Koine Foundations', '#'],
                        ['Christian Leaders Institute Greek', 'https://www.christianleadersinstitute.org'],
                    ]],
                    ['grupo' => 'Intermediate Greek', 'links' => [
                        ['Daily Dose of Greek', 'https://dailydoseofgreek.com'],
                        ['Koine Guide', '#'],
                    ]],
                    ['grupo' => 'Greek New Testament Tools', 'links' => [
                        ['STEP Bible', 'https://www.stepbible.org'],
                        ['Bible Hub Greek', 'https://biblehub.com/greek/'],
                        ['Blue Letter Bible', 'https://www.blueletterbible.org'],
                        ['SBL Greek New Testament', 'https://sblgnt.com'],
                        ['Greek New Testament Gateway', '#'],
                    ]],
                    ['grupo' => 'Advanced Greek', 'links' => [
                        ['Logeion Greek Dictionary', 'https://logeion.uchicago.edu'],
                        ['Perseus Digital Library', 'https://www.perseus.tufts.edu'],
                        ['Tufts Morphological Analyzer', '#'],
                        ['A.T. Robertson Grammar', '#'],
                        ['Biblical Language Center', 'https://www.biblicallanguagecenter.com'],
                        ['Open Greek and Latin Project', '#'],
                    ]],
                ],
            ],

            // ===================== LATIN =====================
            [
                'slug' => 'latin', 'title' => 'Latin', 'icon' => 'fa-landmark',
                'sections' => [
                    ['grupo' => 'Beginner Latin', 'links' => [
                        ['Latinitium', 'https://latinitium.com'],
                        ['LatinTutorial', 'https://latintutorial.com'],
                        ['Legonium', 'https://legonium.com'],
                        ['Open University Latin', '#'],
                        ['Cambridge Latin Course', 'https://www.cambridgescp.com'],
                    ]],
                    ['grupo' => 'Intermediate Latin', 'links' => [
                        ['Oxford Latin Resources', '#'],
                        ['Ancient Language Institute', 'https://ancientlanguage.com'],
                        ['Paideia Institute Living Latin', 'https://www.paideiainstitute.org'],
                        ['Scorpio Martianus', '#'],
                    ]],
                    ['grupo' => 'Reading Latin Texts', 'links' => [
                        ['The Latin Library', 'https://www.thelatinlibrary.com'],
                        ['Perseus Latin Collection', 'https://www.perseus.tufts.edu'],
                        ['PHI Latin Texts', 'https://latin.packhum.org'],
                        ['Dickinson College Commentaries', 'https://dcc.dickinson.edu'],
                    ]],
                    ['grupo' => 'Advanced Latin', 'links' => [
                        ["Whitaker's Words", '#'],
                        ['Logeion Latin Dictionary', 'https://logeion.uchicago.edu'],
                        ['Corpus Corporum', 'https://mlat.uzh.ch'],
                        ['LacusCurtius', 'https://penelope.uchicago.edu/Thayer/E/Roman/home.html'],
                    ]],
                ],
            ],

            // ===================== DESCRIPTIVE LINGUISTICS =====================
            [
                'slug' => 'descriptive-linguistics', 'title' => 'Descriptive Linguistics', 'icon' => 'fa-comments',
                'sections' => [
                    ['grupo' => 'General Linguistics', 'links' => [
                        ['Linguistic Society of America', 'https://www.linguisticsociety.org'],
                        ['MIT OpenCourseWare Linguistics', 'https://ocw.mit.edu'],
                        ['Open Yale Linguistics', 'https://oyc.yale.edu'],
                        ['Coursera Linguistics', 'https://www.coursera.org'],
                        ['edX Linguistics', 'https://www.edx.org'],
                    ]],
                    ['grupo' => 'Phonetics', 'links' => [
                        ['International Phonetic Association', 'https://www.internationalphoneticassociation.org'],
                        ['IPA Chart Interactive', 'https://www.ipachart.com'],
                        ['UCLA Phonetics Lab Archive', 'https://phonetics.ucla.edu'],
                        ['Praat', 'https://www.fon.hum.uva.nl/praat/'],
                        ['Speech Accent Archive', 'https://accent.gmu.edu'],
                    ]],
                    ['grupo' => 'Phonology', 'links' => [
                        ['SIL Linguistics Glossary', 'https://glossary.sil.org'],
                        ['Rutgers OT Archive', 'https://roa.rutgers.edu'],
                    ]],
                    ['grupo' => 'Morphology and Typology', 'links' => [
                        ['Morphology Archive', '#'],
                        ['WALS', 'https://wals.info'],
                        ['AUTOTYP', '#'],
                        ['Glottopedia', 'https://www.glottopedia.org'],
                    ]],
                    ['grupo' => 'Syntax', 'links' => [
                        ['Universal Dependencies', 'https://universaldependencies.org'],
                        ['SyntaxNet', '#'],
                    ]],
                    ['grupo' => 'Semantics and Pragmatics', 'links' => [
                        ['Stanford Encyclopedia of Philosophy', 'https://plato.stanford.edu'],
                        ['Natural Semantic Metalanguage', '#'],
                        ['Pragmatics Association', '#'],
                    ]],
                    ['grupo' => 'Language Documentation', 'links' => [
                        ['ELAR', 'https://www.elararchive.org'],
                        ['PARADISEC', 'https://www.paradisec.org.au'],
                        ['DOBES Archive', '#'],
                        ['SIL International', 'https://www.sil.org'],
                        ['FLEx', 'https://software.sil.org/fieldworks'],
                        ['SayMore', 'https://software.sil.org/saymore'],
                        ['ELAN', '#'],
                    ]],
                    ['grupo' => 'Lexicography', 'links' => [
                        ['TLex Suite', 'https://tshwanedje.com'],
                        ['Lexonomy', 'https://www.lexonomy.eu'],
                        ['Sketch Engine', 'https://www.sketchengine.eu'],
                        ['Corpus Workbench', '#'],
                    ]],
                    ['grupo' => 'Corpus Linguistics', 'links' => [
                        ['AntConc', 'https://www.laurenceanthony.net/software/antconc/'],
                        ['LancsBox', '#'],
                        ['CLARIN', 'https://www.clarin.eu'],
                    ]],
                    ['grupo' => 'Endangered Languages', 'links' => [
                        ['Endangered Languages Project', 'https://www.endangeredlanguages.com'],
                        ['Living Tongues Institute', 'https://livingtongues.org'],
                        ['Rosetta Project', 'https://rosettaproject.org'],
                        ['AILLA', 'https://ailla.utexas.org'],
                    ]],
                    ['grupo' => 'Journals and Research', 'links' => [
                        ['Language Journal', '#'],
                        ['Linguistic Typology', '#'],
                        ['Journal of Linguistics', '#'],
                        ['Studies in Language', '#'],
                        ['International Journal of American Linguistics', '#'],
                    ]],
                ],
            ],

            // ===================== MASTER RESEARCH RESOURCES =====================
            [
                'slug' => 'master-research-resources', 'title' => 'Master Research Resources', 'icon' => 'fa-book',
                'sections' => [
                    ['grupo' => null, 'links' => [
                        ['Bible Odyssey', 'https://www.bibleodyssey.org'],
                        ['Early Christian Writings', 'https://www.earlychristianwritings.com'],
                        ['CCEL', 'https://www.ccel.org'],
                        ['Internet Sacred Text Archive', 'https://www.sacred-texts.com'],
                        ['Archive.org', 'https://archive.org'],
                        ['Google Books', 'https://books.google.com'],
                        ['Glottolog', 'https://glottolog.org'],
                        ['PHOIBLE', 'https://phoible.org'],
                        ['Ethnologue', 'https://www.ethnologue.com'],
                        ['Open Greek and Latin Project', '#'],
                    ]],
                ],
            ],
        ];
    }
}
