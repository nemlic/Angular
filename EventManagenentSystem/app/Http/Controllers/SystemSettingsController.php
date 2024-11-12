<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'name');
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'setting_name' => 'required|string',
            'setting_value' => 'required|string',
        ]);

        $setting = Setting::updateOrCreate(
            ['name' => $request->setting_name],
            ['value' => $request->setting_value]
        );

        return response()->json(['message' => 'Settings updated successfully.', 'setting' => $setting]);
    }
}
