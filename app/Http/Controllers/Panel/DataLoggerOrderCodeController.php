<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataloggerOrdercodeRequest;
use App\Models\Datalogger;
use App\Models\DataloggerOrderCode;
use App\Models\OrderCode;
use Illuminate\Http\Request;

class DataLoggerOrderCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Datalogger $device)
    {
        return view('app.data-logger.order-code.index',compact('device'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Datalogger $device)
    {
        $orderCodes=OrderCode::all();
        $timeCycles=DataloggerOrderCode::$timeCycle;
        return view('app.data-logger.order-code.create',compact('device','orderCodes','timeCycles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataloggerOrdercodeRequest $request,Datalogger $device)
    {
        

        $device->order_codes()->attach([$request->order_code_id=> ['time' => $request->time]]);
        return redirect()->route('app.data-logger.order-code', $device->id )->with('swal-success', ' کد کنترل با موفقیت اضافه شد');
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
        $orderCodes=OrderCode::all();
        return view('app.data-logger.order-code.edit',compact('device','orderCodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function status(Datalogger $device)
    {

        
        

    }
}
