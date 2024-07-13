<?php

namespace App\Http\Controllers\Panel;

use App\Models\OrderCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCodeRequest;

class OrderCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders=OrderCode::all();
        return view('app.order-code.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.order-code.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderCodeRequest $request)
    {
        $inputs=$request->all();

        $result=OrderCode::create($inputs);
        return redirect()->route('app.order-code.index')->with('swal-success', ' کد جدید با موفقیت ایجاد شد');

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
    public function edit(OrderCode $orderCode)
    {
        return view('app.order-code.edit',compact('orderCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderCodeRequest $request, OrderCode $orderCode)
    {
        $inputs=$request->all();
        $orderCode->update($inputs);
        return redirect()->route('app.order-code.index')->with('swal-success', ' کد با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
