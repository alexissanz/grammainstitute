<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::current();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(SettingsRequest $request)
    {
        $settings = SiteSetting::current();
        $data     = $request->validated();

        // Checkbox: when unchecked, no value is sent
        $data['whatsapp_ativo'] = $request->boolean('whatsapp_ativo');

        // File uploads: images
        foreach (['logo', 'favicon', 'imagem_hero', 'founder_foto', 'founder_assinatura'] as $field) {
            if ($request->hasFile($field)) {
                if ($settings->$field) {
                    Storage::disk('public')->delete($settings->$field);
                }
                $data[$field] = $request->file($field)->store('site', 'public');
            } else {
                unset($data[$field]);
            }
        }

        // File upload: video hero (max 50MB)
        if ($request->hasFile('hero_video')) {
            if ($settings->hero_video) {
                Storage::disk('public')->delete($settings->hero_video);
            }
            $data['hero_video'] = $request->file('hero_video')->store('site/videos', 'public');
        } else {
            unset($data['hero_video']);
        }

        // Don't overwrite SMTP password if blank
        if (empty($data['smtp_password'])) {
            unset($data['smtp_password']);
        }

        // Normalize active languages array
        if (isset($data['idiomas_activos']) && is_array($data['idiomas_activos'])) {
            $data['idiomas_activos'] = array_values($data['idiomas_activos']);
        }

        $settings->update($data);

        return redirect()->route('admin.settings.edit')
            ->with('success', __('settings.saved'));
    }
}
