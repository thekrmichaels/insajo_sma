<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; // Hace referencia al usuario autenticado en el controlador.
use App\Models\User;
use Spatie\Permission\Models\Role; // Hace referencia al modelo Rol de Spatie.
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Flash;

class ActivityController extends Controller
{

    public function __construct()
    {
        // Estructura: $this->middleware('can:route_name.method')->only('method');
        $this->middleware('can:activities.index')->only('index');
        $this->middleware('can:activities.create')->only('create');
        $this->middleware('can:activities.edit')->only('edit');
        $this->middleware('can:activities.store')->only('store');
        $this->middleware('can:activities.show')->only('show');
        $this->middleware('can:activities.update')->only('update');
        $this->middleware('can:activities.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $id = Auth::id();
        $user = User::findOrFail($id);
        if ($user->hasRole(['Administrador'])) {
            $activities = Activity::query()
                                    ->with(['teacher'])
                                    ->when(request('search'), function($query) {
                                        return $query->where('name', 'LIKE', '%'.request('search').'%')
                                        ->orWhereHas('teacher', function ($query2) {
                                            $query2->where('class_name', 'LIKE', '%'.request('search').'%');
                                        });
                                    })
                                    ->orderBy('id', 'asc')
                                    ->paginate();
        }
        if ($user->hasRole(['Docente'])) {
            $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                    ->join('users', 'teachers.user_id', '=', 'users.id')
                                    ->where('users.id', '=', $id)
                                    ->where(function($query) use ($search) {
                                        $query->where('teachers.class_name', 'LIKE', '%'.$search.'%')
                                                ->orWhere('activities.name', 'LIKE', '%'.$search.'%');
                                    })
                                    ->select('activities.*')
                                    ->orderBy('id', 'asc')
                                    ->get();
        }
        if ($user->hasRole(['Estudiante'])) {
            $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                    ->join('classrooms', 'teachers.classroom_id', '=', 'classrooms.id')
                                    ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                                    ->join('users', 'students.user_id', '=', 'users.id')
                                    ->where('users.id', '=', $id)
                                    ->where('activities.status', '=', 'Activa')
                                    ->where(function($query) use ($search) {
                                        $query->where('teachers.class_name', 'LIKE', '%'.$search.'%')
                                                ->orWhere('activities.name', 'LIKE', '%'.$search.'%');
                                    })
                                    ->select('activities.*')
                                    ->orderBy('id', 'asc')
                                    ->get();
        }
        return view('activities.index', ['activities' => $activities, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() // Pruebas faltantes. El administrador debería crear actividades.
    {
        $user = Auth::id();
        $in_session_user = User::findOrFail($user);
        if ($in_session_user->hasRole(['Administrador'])) {
            $classes = Teacher::pluck('class_name', 'id');
        } else {
            $classes = Teacher::where('user_id', $user)->pluck('class_name', 'id');
        }
        return view('activities.create', ['classes' => $classes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreActivityRequest $request)
    {
        $activity = $request->except('_token');
        $activity['uuid'] = (string) Str::uuid();

        if ($request->hasFile('homework')) {
            $file = $request->file('homework')->getClientOriginalName();
            $activity['homework'] = $request->file('homework')
                                            ->storeAs(
                                                        'activities/'.$request->teacher_id,
                                                        $file,
                                                        'public'
                                                    );
        }

        Activity::insert($activity);
        Flash::success('Actividad creada exitosamente.');
        return redirect()->route('activities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(/*Activity $activity*/ $id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.show', ['activity' => $activity]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Activity $activity*/ $id)
    {
        $user = Auth::id();
        $in_session_user = User::findOrFail($user);
        $activity = Activity::findOrFail($id);
        if ($in_session_user->hasRole(['Administrador'])) {
            $classes = Teacher::pluck('class_name', 'id');
        } else {
            $teacher = Auth::id();
            $classes = Teacher::where('user_id', $teacher)->pluck('class_name', 'id');
        }
        return view('activities.edit', ['activity' => $activity, 'classes' => $classes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateActivityRequest $request, /*Activity $activity*/ $id)
    {
        $activity = $request->except('_token', '_method');

        $activity['uuid'] = (string) Str::uuid();

        if ($request->hasFile('homework')) {
            $file = $request->file('homework')->getClientOriginalName();
            $activity['homework'] = $request->file('homework')
                                            ->storeAs(
                                                        'activities/'.$request->teacher_id,
                                                        $file,
                                                        'public'
                                                    );
        }

        Activity::where('id', '=', $id)->update($activity);
        Flash::success('Actividad actualizada exitosamente.');
        return redirect()->route('activities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Activity $activity*/ $id)
    {
        Activity::destroy($id);
        Flash::success('Actividad borrada exitosamente.');
        return redirect()->route('activities.index');
    }

    public function download($uuid)
    {
        $activity = Activity::where('uuid', '=', $uuid)->firstOrFail();
        $file = storage_path('app/public/'.$activity->homework);
        return response()->download($file);
    }
}
