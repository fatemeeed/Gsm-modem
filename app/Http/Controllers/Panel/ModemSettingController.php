<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ModemSettingController extends Controller
{
    public function index()
    {
        $settings=Setting::all();
        return view('app.setting.index',compact('settings'));
    }

    public function edit(Setting $setting)
    {
        return view('app.setting.edit',compact('setting'));
    }
}
