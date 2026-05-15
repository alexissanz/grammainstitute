<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::current();

        $smtpConfigured = !empty($settings->smtp_host) && !empty($settings->smtp_username);
        $activeLanguages = is_array($settings->idiomas_activos) ? count($settings->idiomas_activos) : 0;

        return view('admin.dashboard', compact('settings', 'smtpConfigured', 'activeLanguages'));
    }
}
