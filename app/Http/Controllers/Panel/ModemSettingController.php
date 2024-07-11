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

    public function update(Request $request,Setting $setting)
    {
        $inputs=$request->all();
        $resault=$setting->update($inputs);
        return redirect()->route('app.setting.index')->with('swal-success', ' ویرایش با موفقیت ثبت شد');

    }
}
