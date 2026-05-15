<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private function settings(): SiteSetting
    {
        return SiteSetting::current();
    }

    public function home()
    {
        return view('public.home', ['settings' => $this->settings()]);
    }

    public function about()
    {
        return view('public.about', ['settings' => $this->settings()]);
    }

    public function courses()
    {
        return view('public.courses', ['settings' => $this->settings()]);
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
