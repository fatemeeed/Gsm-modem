<?php

namespace App\Http\Controllers\Panel;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\IndustrialCity;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class ModemSettingController extends Controller
{
    public function index()
    {
        $settings=Setting::all();
        return view('app.setting.index',compact('settings'));
    }

    public function create()
    {

        $industrials=IndustrialCity::all();
        return view('app.setting.create',compact('industrials'));
    }

    public function store(SettingRequest $request)
    {
        $inputs=$request->all();
        $setting=Setting::create($inputs);
        return redirect()->route('app.setting.index')->with('swal-success', ' تنظیمات جدید با موفقیت ثبت شد');


    }

    public function edit(Setting $setting)
    {
        return view('app.setting.edit',compact('setting'));
    }

    public function update(SettingRequest $request,Setting $setting)
    {
        $inputs=$request->all();
        $resault=$setting->update($inputs);
        return redirect()->route('app.setting.index')->with('swal-success', ' ویرایش با موفقیت ثبت شد');

    }

    public function status(Setting $setting)
    {

        $setting->status = $setting->status == 0 ? 1 : 0;
        $result = $setting->save();
        if ($result) {
            if ($setting->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
