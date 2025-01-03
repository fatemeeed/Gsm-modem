<?php

namespace App\Http\Controllers\Panel;

use App\Models\Role;
use App\Models\CheckCode;
use Illuminate\Http\Request;
use App\Models\IndustrialCity;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckCodeRequest;

class CheckCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkCodes=CheckCode::all();
        return view('app.check-code.index',compact('checkCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.check-code.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckCodeRequest $request)
    {
        $inputs = $request->all();
        $checkCode=CheckCode::create($inputs);
        return redirect()->route('app.check-code.index')->with('swal-success', ' کد جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckCode $checkCode)
    {
        return view('app.check-code.edit',compact('checkCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckCodeRequest $request, CheckCode $checkCode)
    {
        $inputs = $request->all();
        $checkCode->update($inputs);
        return redirect()->route('app.check-code.index')->with('swal-success', ' کد با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckCode $checkCode)
    {
        $checkCode->delete();
        return redirect()->route('app.check-code.index')->with('swal-success', ' کد با موفقیت حذف شد');

    }
}
