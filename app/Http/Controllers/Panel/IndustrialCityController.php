<?php

namespace App\Http\Controllers\Panel;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\IndustrialCity;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustrialRequest;

class IndustrialCityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industrials=IndustrialCity::all();
        return view('app.industrial-city.index',compact('industrials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces=Province::all();
        return view('app.industrial-city.create',compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndustrialRequest $request)
    {
        $inputs=$request->all();
        $industrial=IndustrialCity::create($inputs);
        return redirect()->route('app.industrial.index')->with('swal-success', ' شهرک صنعتی جدید با موفقیت ثبت شد');

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
    public function edit(string $id)
    {
        //
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

    public function fetchCity(Request $request)
    {

        // if($request->city_id){

        // }
	
        
        $data['cities'] = City::where("province_id",$request->province_id)->get(["name", "id"]);
		
        return response()->json($data);
    }
}