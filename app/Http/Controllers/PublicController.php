<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\Course;
use App\Models\Event;
use App\Models\GlossaryTerm;
use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Promotion;
use App\Models\ResourceCategory;
use App\Models\SiteSetting;

class PublicController extends Controller
{
    private array $hiddenCourseSlugs = [
        'espanhol',
        'portugues',
        'portugues-para-estrangeiros-ple',
        'portuguese-for-foreigners-pfl',
    ];

    private function settings(): SiteSetting
    {
        return SiteSetting::current();
    }

    public function home()
    {
        $settings = $this->settings();

        $heroSlides = [];
        if ($settings->hero_tipo === 'slides') {
            $heroSlides = HeroSlide::where('ativo', true)->orderBy('ordem')->get();
        }

        $courses = $this->visibleCourses()->orderBy('ordem')->get();
        $featuredTerms = GlossaryTerm::where('ativo', true)
            ->where('destaque', true)
            ->orderBy('ordem')
            ->limit(3)
            ->get();

        $upcomingEvents = Event::where('ativo', true)
            ->where(function ($q) {
                $q->where('data_inicio', '>=', now())
                  ->orWhere('data_fim', '>=', now());
            })
            ->orderBy('data_inicio')
            ->limit(3)
            ->get();

        $homePromotions = Promotion::activeForHome();

        return view('public.home', compact(
            'settings', 'heroSlides', 'courses',
            'featuredTerms', 'upcomingEvents', 'homePromotions'
        ));
    }

    public function events()
    {
        $upcoming = Event::where('ativo', true)
            ->where(function ($q) {
                $q->where('data_inicio', '>=', now())
                  ->orWhere('data_fim', '>=', now());
            })
            ->orderBy('data_inicio')
            ->get();

        $past = Event::where('ativo', true)
            ->where('data_fim', '<', now())
            ->orderByDesc('data_inicio')
            ->limit(6)
            ->get();

        return view('public.events', [
            'settings' => $this->settings(),
            'upcoming' => $upcoming,
            'past'     => $past,
        ]);
    }

    public function eventShow(Event $event)
    {
        abort_if(! $event->ativo, 404);
        $upcoming = Event::where('ativo', true)
            ->where('id', '!=', $event->id)
            ->where(function ($q) {
                $q->where('data_inicio', '>=', now())
                  ->orWhere('data_fim', '>=', now());
            })
            ->orderBy('data_inicio')
            ->limit(3)
            ->get();
        return view('public.event-show', [
            'settings' => $this->settings(),
            'event'    => $event,
            'upcoming' => $upcoming,
        ]);
    }

    public function about()
    {
        return view('public.about-index', [
            'settings' => $this->settings(),
            'about'    => AboutPage::current(),
            'sections' => $this->aboutSections(),
        ]);
    }

    public function aboutSection(string $section)
    {
        $sections = $this->aboutSections();
        abort_unless(isset($sections[$section]), 404);

        return view('public.about-section', [
            'settings' => $this->settings(),
            'about'    => AboutPage::current(),
            'sections' => $sections,
            'current'  => $section,
        ]);
    }

    /** Section catalog used by both the index and the per-section view. */
    private function aboutSections(): array
    {
        return [
            'who-is' => [
                'title_field' => 'founder_title',
                'text_field'  => 'founder_text',
                'fallback'    => 'About Us',
                'icon'        => 'fa-user',
            ],
            'the-institute' => [
                'title_field' => 'institute_title',
                'text_field'  => 'institute_text',
                'fallback'    => 'The Gramma Institute of Linguistics',
                'icon'        => 'fa-landmark',
            ],
            'mission' => [
                'title_field' => 'mission_title',
                'text_field'  => 'mission_text',
                'fallback'    => 'Mission',
                'icon'        => 'fa-compass',
            ],
            'areas-of-expertise' => [
                'title_field' => 'expertise_title',
                'text_field'  => null,
                'fallback'    => 'Areas of Expertise',
                'icon'        => 'fa-scroll',
            ],
            'closing-statement' => [
                'title_field' => 'closing_title',
                'text_field'  => 'closing_text',
                'fallback'    => 'Closing Statement',
                'icon'        => 'fa-quote-right',
            ],
        ];
    }

    public function founder()
    {
        return view('public.founder', ['settings' => $this->settings()]);
    }

    public function courses()
    {
        $courses = $this->visibleCourses()->orderBy('ordem')->get();
        return view('public.courses', [
            'settings' => $this->settings(),
            'courses'  => $courses,
        ]);
    }

    public function courseShow(Course $course)
    {
        abort_if(! $course->ativo, 404);
        $related = $this->visibleCourses()
            ->where('id', '!=', $course->id)
            ->orderBy('ordem')
            ->limit(3)
            ->get();
        return view('public.course-show', [
            'settings' => $this->settings(),
            'course'   => $course,
            'related'  => $related,
        ]);
    }

    public function glossary()
    {
        $terms = GlossaryTerm::where('ativo', true)
            ->whereNotNull('letra')
            ->orderBy('ordem')
            ->orderBy('letra')
            ->orderBy('termo')
            ->get();

        $letters = $terms->map(fn (GlossaryTerm $term) => $term->letterKey())
            ->unique()
            ->values();

        $groups = $terms->groupBy(fn (GlossaryTerm $term) => $term->letterKey());

        return view('public.glossary', [
            'settings' => $this->settings(),
            'terms'    => $terms,
            'letters'  => $letters,
            'groups'   => $groups,
        ]);
    }

    public function glossaryShow(GlossaryTerm $term)
    {
        abort_if(! $term->ativo, 404);
        $related = GlossaryTerm::where('ativo', true)
            ->where('id', '!=', $term->id)
            ->where('lingua', $term->lingua)
            ->orderBy('ordem')
            ->limit(3)
            ->get();
        return view('public.glossary-show', [
            'settings' => $this->settings(),
            'term'     => $term,
            'related'  => $related,
        ]);
    }

    public function methodology()
    {
        return view('public.methodology', ['settings' => $this->settings()]);
    }

    public function contact()
    {
        return view('public.contact', ['settings' => $this->settings()]);
    }

    private function visibleCourses()
    {
        return Course::where('ativo', true)->whereNotIn('slug', $this->hiddenCourseSlugs);
    }

    public function partners()
    {
        return view('public.partners', [
            'settings' => $this->settings(),
            'partners' => Partner::where('ativo', true)->orderBy('ordem')->orderBy('id')->get(),
        ]);
    }

    public function resources()
    {
        return view('public.resources-index', [
            'settings'   => $this->settings(),
            'categories' => ResourceCategory::where('ativo', true)->orderBy('ordem')->orderBy('id')->get(),
        ]);
    }

    public function resourceCategory(ResourceCategory $category)
    {
        abort_unless($category->ativo, 404);
        return view('public.resources-category', [
            'settings'   => $this->settings(),
            'category'   => $category,
            'links'      => $category->activeLinks()->get(),
            'categories' => ResourceCategory::where('ativo', true)->orderBy('ordem')->orderBy('id')->get(),
        ]);
    }

    public function privacy()
    {
        return view('public.privacy', ['settings' => $this->settings()]);
    }

    public function terms()
    {
        return view('public.terms', ['settings' => $this->settings()]);
    }
}
