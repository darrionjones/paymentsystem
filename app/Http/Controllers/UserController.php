<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {

        //add search functionalitycd
        $searchTerm = request('search');
        auth()->user()->getRoleNames()->first() == 'merchant' ? $users = User::role('merchant')->filter()->paginate(15) : $users = User::role('admin')->filter()->paginate(15);

        return view('users.index', ['users' => $users, 'searchTerm' => $searchTerm]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = Role::get();

        $merchants = Merchant::select('id', 'business_name')->get();

        return view('users.create', compact('roles', 'merchants'));
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request)
    {

        /**
         * Validate the request data
         */
        $user = auth()->user();
        $authRole = $user->getRoleNames()->first();

        $validatedData = $request->validated();

        /**
         * Create the user
         */
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->phone_number = $validatedData['phone_number'];

        $merchant = Merchant::findOrFail($validatedData['merchant_id']);
        $user->merchant()->associate($merchant);
        $user->save();

        $authRole == 'merchant' ? $user->assignRole($authRole) : $user->assignRole($validatedData['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the details of the specified user
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, $id)
    {

        $validatedData = $request->validated();

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (! empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->phone_number = $validatedData['phone_number'];
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
