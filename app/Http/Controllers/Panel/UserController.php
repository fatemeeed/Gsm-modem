<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->simplepaginate(15);
        return view('app.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $inputs = $request->all();
       


        $inputs['password'] = Hash::make($request->password);
        $inputs['name'] = $request->first_name . ' ' . $request->last_name;

        $user = User::create($inputs);

        
        return redirect()->route('app.user.index')->with('swal-success', ' کاربر جدید با موفقیت ثبت شد');
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
    public function edit(User $user)
    {
        return view('app.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        
        $user->update($inputs);
        return redirect()->route('app.user.index')->with('swal-success', ' ویرایش با موفقیت ثبت شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->Delete();
        return redirect()->route('app.user.index')->with('swal-success', 'کاربر  با موفقیت حذف شد');
    }

    public function activation(User $user)
    {

        $user->activation = $user->activation == 0 ? 1 : 0;
        $result = $user->save();
        if ($result) {
            if ($user->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function resetPassword(User $user)
    {
        return view('app.user.reset-password', compact('user'));
    }

    public function postResetPassword(Request $request, User $user)
    {
        $validatedData = $request->validate([

            'password'   => ['required', 'unique:users', Password::min(8)->letters()->mixedCase()->symbols()->uncompromised(), 'confirmed'],

        ]);

        $inputs = $request->all();

        $inputs['password'] = Hash::make($request->password);
        $user->update($inputs);
        return redirect()->route('app.user.index')->with('swal-success', 'ریست پسورد با موفقیت انجام شد');
    }
}
