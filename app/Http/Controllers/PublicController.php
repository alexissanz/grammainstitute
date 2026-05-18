<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\GlossaryTerm;
use App\Models\HeroSlide;
use App\Models\Promotion;
use App\Models\SiteSetting;

class PublicController extends Controller
{
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

        $courses = Course::where('ativo', true)->orderBy('ordem')->get();
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
        return view('public.about', ['settings' => $this->settings()]);
    }

    public function founder()
    {
        return view('public.founder', ['settings' => $this->settings()]);
    }

    public function courses()
    {
        $courses = Course::where('ativo', true)->orderBy('ordem')->get();
        return view('public.courses', [
            'settings' => $this->settings(),
            'courses'  => $courses,
        ]);
    }

    public function courseShow(Course $course)
    {
        abort_if(! $course->ativo, 404);
        $related = Course::where('ativo', true)
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
        $terms = GlossaryTerm::where('ativo', true)->orderBy('ordem')->get();
        return view('public.glossary', [
            'settings' => $this->settings(),
            'terms'    => $terms,
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

    public function privacy()
    {
        return view('public.privacy', ['settings' => $this->settings()]);
    }

    public function terms()
    {
        return view('public.terms', ['settings' => $this->settings()]);
    }
}
