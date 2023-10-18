<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MerchantUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('merchants.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Merchant $merchant)
    {

        return view('merchants.users.create', compact('merchant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Merchant $merchant)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'phone_number' => 'required',
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone_number = $request->input('phone_number');
        $user->merchant_id = $merchant->id;
        $user->save();

        $user->assignRole('merchant');

        //redirect to the merchant details page
        return redirect()->route('merchants.show', $merchant->id)->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchant $merchant, User $user)
    {
        return view('merchants.users.edit', compact('merchant', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Merchant $merchant, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('merchants.users.index', $merchant->id)->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchant $merchant, User $user)
    {
        $user->delete();

        return redirect()->route('merchants.users.index', $merchant->id)->with('success', 'User deleted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant, User $user)
    {
        return view('merchants.users.show', compact('merchant', 'user'));
    }
}
