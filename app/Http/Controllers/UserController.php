<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // * spatie/laravel-permission package: Allows users to be associated with permissions and roles.

class UserController extends Controller
{
    /**
     * * spatie/laravel-permission package: Required permissions.
     */
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create');
        $this->middleware('can:users.store')->only('store');
        $this->middleware('can:users.show')->only('show');
        $this->middleware('can:users.edit')->only('edit');
        $this->middleware('can:users.update')->only('update');
        $this->middleware('can:users.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles' => function ($query) {
            $query->select('name');
        }])->select('id', 'name', 'email', 'status')->get();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($input['roles']);
        if ($user['status'] == 'Deshabilitado') {
            $user->ban();
        }
        flash('Usuario creado exitosamente.')->success();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $role = $user->getRoleNames()->first();
        return view('users.show', ['user' => $user, 'role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();
        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();
        if (filled($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = $request->except('password');
        }

        // * spatie/laravel-permission package: Reassign user role.
        if ($user->getRoleNames()->first() != $input['roles']) {
            DB::table('model_has_roles')->where('model_id', $user['id'])->delete();
            $user->assignRole($input['roles']);
        }

        // * cybercog/laravel-ban package: Reassign user status.
        if ($user['status'] != $input['status']) {
            if ($input['status'] == 'Habilitado') {
                $user->unban();
                DB::table('bans')->where('bannable_id', $user['id'])->delete(); // ! Deletes the records of the unbanned user.
            } elseif ($input['status'] == 'Deshabilitado') {
                $user->ban();
            }
        }
        $user->update($input);
        flash('Usuario actualizado exitosamente.')->success();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $deleted_user = $user['id'];
        User::destroy($user['id']);
        DB::table('model_has_roles')->where('model_id', $deleted_user)->delete();
        DB::table('bans')->where('bannable_id', $deleted_user)->delete();
        flash('Usuario eliminado exitosamente.')->success();
        return redirect()->route('users.index');
    }
}
