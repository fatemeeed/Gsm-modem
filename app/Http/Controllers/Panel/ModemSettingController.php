<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModemSettingController extends Controller
{
    public function index()
    {
        $settin
        return view('app.setting.index');
    }

    public function edit( $setting)
    {
        return view('app.setting.edit',compact('setting'));
    }
}
