<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailTestController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::current();
        return view('admin.email-test', compact('settings'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'to'      => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $settings = SiteSetting::current();

        if (empty($settings->smtp_host)) {
            return back()->withErrors(['smtp' => __('email.smtp_missing')]);
        }

        $this->applySmtpSettings($settings);

        try {
            Mail::to($request->to)->send(new TestMail(
                $request->subject,
                $request->message,
                $settings
            ));

            return back()->with('success', __('email.sent'));
        } catch (\Exception $e) {
            Log::error('Email test failed: ' . $e->getMessage());
            return back()->withErrors(['smtp' => __('email.error', ['error' => $e->getMessage()])]);
        }
    }

    private function applySmtpSettings(SiteSetting $settings): void
    {
        Config::set('mail.mailer', 'smtp');
        Config::set('mail.host', $settings->smtp_host);
        Config::set('mail.port', $settings->smtp_port);
        Config::set('mail.username', $settings->smtp_username);
        Config::set('mail.password', $settings->smtp_password);
        Config::set('mail.encryption', $settings->smtp_encryption);
        Config::set('mail.from.address', $settings->smtp_from_address ?: $settings->email_institucional);
        Config::set('mail.from.name', $settings->smtp_from_name ?: $settings->nome_site);
    }
}
