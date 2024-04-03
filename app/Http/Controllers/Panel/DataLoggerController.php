<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataLoggerRequest;
use App\Models\City;
use App\Models\Datalogger;
use Illuminate\Http\Request;

class DataLoggerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices=Datalogger::all();
        return view('app.data-logger.index',compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities=City::all();
        return view('app.data-logger.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataLoggerRequest $request)
    {
        $inputs=$request->all();
        
        $resualt=Datalogger::create($inputs);
        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز جدید با موفقیت ثبت شد');

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
    public function edit(Datalogger $device)
    {
        $cities=City::all();
        return view('app.data-logger.edit',compact('cities','device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DataLoggerRequest $request, Datalogger $device)
    {
        $inputs=$request->all();

        $device->update($inputs);
        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز  با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datalogger $device)
    {

        $device->delete();
        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز  با موفقیت حذف شد');
        
    }

    public function status(Datalogger $device){

        $device->status = $device->status == 0 ? 1 : 0;
        $result = $device->save();
        if($result){
                if($device->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }
}
