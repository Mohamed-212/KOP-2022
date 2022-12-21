<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogfileTrait;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use LogfileTrait;

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->whereHas('roles', function ($role) {
            $role->where('name', '!=', 'customer');
        })->with('roles')->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\User','view',0);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'customer')->get();
        $branches = Branch::get();
        return view('admin.user.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:20',
            'middle_name' => 'nullable|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'roles' => 'required|array',
            'branches' => 'required|array',
            'email' => 'required|email|unique:users,email', 
            'first_phone' => 'required|numeric|digits:12',
            'second_phone' => 'nullable|numeric|digits:12',
            'password' => 'required|confirmed|min:4',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }

        if ($request->filled('middle_name')) {
            $name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
        }


        $user = User::create([
            'name' => $name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'first_phone' => $request->first_phone,
            'second_phone' => $request->second_phone,
            'image' => '',
            'age' => $request->age,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activation_token' => "",
            'active' => 1,
        ]);

        $user->token = $user->createToken('AppName')->accessToken;
        $user->email_verified_at = now();
        $user->active = true;
        $user->activation_token = mt_rand(10000, 99999);
        $user->save();

        $this->Make_Log('App\Models\User','create', $user->id);
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('users'), $image_new_name);
            $user->image = '/users/' . $image_new_name;
            $user->save();
        }


        $user->attachRoles($request->roles);
        $user->branches()->sync($request->branches);

        return redirect()->route('admin.user.index')->with([
            'type' => 'success',
            'message' => 'User insert successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        $branches = Branch::get();
        return view('admin.user.edit', compact('user', 'roles', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:20',
            'middle_name' => 'nullable',
            'last_name' => 'required|min:3|max:20',
            'roles' => 'required|array',
            'email' => 'required|email',
            'first_phone' => 'nullable',
            'age' => 'nullable',
            'second_phone' => 'nullable',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('users'), $image_new_name);
            $user->image = '/users/' . $image_new_name;
            $user->save();
        }
        if ($request->filled('middle_name')) {
            $name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
        }
        $request->merge([
            'name' => $name
        ]);
        //dd($request->all(), $attributes);
        $user->update($request->all());

        $user->roles()->detach();
        $user->roles()->syncWithoutDetaching($request->roles);

        $user->branches()->detach();
        $user->branches()->syncWithoutDetaching($request->branches);
        $this->Make_Log('App\Models\User','update', $user->id);
        return redirect()->route('admin.user.index')->with([
            'type' => 'success',
            'message' => 'User updated successfuly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $this->Make_Log('App\Models\User','delete', $user->id);
        return redirect()->route('admin.user.index')->with([
            'type' => 'error',
            'message' => 'User deleted successfuly'
        ]);
    }
}
