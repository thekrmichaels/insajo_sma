<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role; // Hace referencia al modelo Rol de Spatie.
use Illuminate\Support\Facades\Hash; // Codifica contraseña (Los correos con contraseñas no codificadas no pueden accesar a la plataforma).
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use Flash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(can:'route_name.method')->only('method');
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create');
        $this->middleware('can:users.edit')->only('edit');
        $this->middleware('can:users.store')->only('store');
        $this->middleware('can:users.show')->only('show');
        $this->middleware('can:users.update')->only('update');
        $this->middleware('can:users.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $users = User::select('id', 'name', 'email', 'status')
                        ->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->orWhere('status', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'asc')
                        ->get();
        return view('users.index', ['users' => $users, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if ($input['status'] == "Habilitado") {
            $input['banned_at'] = null;
            $user = User::create($input);
        }
        else {
            $user = User::create($input);
            $user->ban();
        }
        $user->assignRole($input['roles']);
        Flash::success('Usuario creado exitosamente.');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $role = $user->getRoleNames()[0] ?? '' ;
        return view('users.show', ['user' => $user, 'role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateUserRequest $request, $id)
    {
        $input = $request->all();
        if (is_null($input['password'])) {
            $input = $request->except('password');
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        $user = User::findOrFail($id);
        DB::table('bans')->where('bannable_id', $id)->delete();
        if ($input['status'] == "Habilitado") {
            $input['banned_at'] = null;
            $user->update($input);
        }
        else {
            $user->update($input);
            $user->ban();
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($input['roles']);
        Flash::success('Usuario actualizado exitosamente.');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole(['Docente'])) {

            $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                    ->join('users', 'teachers.user_id', '=', 'users.id')
                                    ->where('users.id', $id)
                                    ->count();

            if ($activities > 0) {
                Flash::error('No puede borrar el docente');
            } else {
                User::destroy($id);
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                Flash::success('Usuario borrado exitosamente.');
            }
        } else {
            User::destroy($id);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            Flash::success('Usuario borrado exitosamente.');
        }
        return redirect()->route('users.index');
    }
}
