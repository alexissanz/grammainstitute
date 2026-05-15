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
        $data = $request->validated();

        foreach (['logo', 'favicon', 'imagem_hero'] as $field) {
            if ($request->hasFile($field)) {
                if ($settings->$field) {
                    Storage::disk('public')->delete($settings->$field);
                }
                $data[$field] = $request->file($field)->store('site', 'public');
            } else {
                unset($data[$field]);
            }
        }

        if (empty($data['smtp_password'])) {
            unset($data['smtp_password']);
        }

        if (isset($data['idiomas_activos']) && is_array($data['idiomas_activos'])) {
            $data['idiomas_activos'] = array_values($data['idiomas_activos']);
        }

        $settings->update($data);

        return redirect()->route('admin.settings.edit')
            ->with('success', __('settings.saved'));
    }
}
