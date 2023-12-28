<?php

namespace App\Http\Controllers;

use App\Models\Schoolwork;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth; // Hace referencia al usuario autenticado en el controlador.
use App\Models\Activity;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Flash;
use App\Http\Requests\StoreSchoolworkRequest;
use App\Http\Requests\UpdateSchoolworkRequest;

class SchoolworkController extends Controller
{
    public function __construct()
    {
        // Estructura: $this->middleware('can:route_name.method')->only('method');
        $this->middleware('can:schoolworks.index')->only('index');
        $this->middleware('can:schoolworks.create')->only('create');
        $this->middleware('can:schoolworks.store')->only('store');
        $this->middleware('can:schoolworks.show')->only('show');
        $this->middleware('can:schoolworks.edit')->only('edit');
        $this->middleware('can:schoolworks.update')->only('update');
        $this->middleware('can:schoolworks.destroy')->only('destroy');
        // $this->middleware('can:update score')->only('edit', 'update', 'store');
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
            $schoolworks = Schoolwork::query()
                                        ->with(['activity', 'student.user', 'student.classroom'])
                                        ->whereHas('activity', function ($query2) {
                                            $query2->where('name', 'LIKE', '%'.request('search').'%');
                                        })
                                        ->orWhereHas('student.user', function ($query3) {
                                            $query3->where('name', 'LIKE', '%'.request('search').'%');
                                        })
                                        ->orWhereHas('student.classroom', function ($query4) {
                                            $query4->where('name', 'LIKE', '%'.request('search').'%');
                                        })
                                        ->orderBy('id', 'asc')
                                        ->paginate();
        }
        if ($user->hasRole(['Docente'])) {
            $schoolworks = Schoolwork::join('activities', 'schoolworks.activity_id', '=', 'activities.id')
                                        ->join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                        ->join('users', 'teachers.user_id', '=', 'users.id')
                                        ->join('students', 'schoolworks.student_id', '=', 'students.id')
                                        ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
                                        ->join('users as stdnts', 'students.user_id', '=', 'stdnts.id')
                                        ->where('users.id', '=', $id)
                                        ->select('schoolworks.*')
                                        ->where(function($query) use ($search) {
                                            $query->where('activities.name', 'LIKE', '%'.$search.'%')
                                                    ->orWhere('stdnts.name', 'LIKE', '%'.$search.'%')
                                                    ->orWhere('classrooms.name', 'LIKE', '%'.$search.'%');
                                        })
                                        ->orderBy('schoolworks.id', 'asc')
                                        ->get();
        }
        if ($user->hasRole(['Estudiante'])) {
            $schoolworks = Schoolwork::join('activities', 'schoolworks.activity_id', '=', 'activities.id')
                                        ->join('students', 'schoolworks.student_id', '=', 'students.id')
                                        ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
                                        ->join('users as stdnts', 'students.user_id', '=', 'stdnts.id')
                                        ->where('stdnts.id', '=', $id)
                                        ->select('schoolworks.*')
                                        ->where(function($query) use ($search) {
                                            $query->where('activities.name', 'LIKE', '%'.$search.'%')
                                                    ->orWhere('stdnts.name', 'LIKE', '%'.$search.'%')
                                                    ->orWhere('classrooms.name', 'LIKE', '%'.$search.'%');
                                        })
                                        ->orderBy('schoolworks.id', 'asc')
                                        ->get();
        }
        return view('schoolworks.index', ['schoolworks' => $schoolworks, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::id();

        $finished_activities = Activity::join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                                            ->join('students', 'students.id', '=', 'schoolworks.student_id')
                                            ->join('users', 'users.id', '=', 'students.user_id')
                                            ->where('users.id', '=', $user)
                                            ->pluck('activities.id');

        $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                ->join('classrooms', 'teachers.classroom_id', '=', 'classrooms.id')
                                ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                                ->join('users', 'students.user_id', '=', 'users.id')
                                ->where('users.id', '=', $user)
                                ->where('activities.status', '=', 'Activa')
                                ->whereNotIn('activities.id', $finished_activities)
                                ->where('activities.deadline', '>', Carbon::now())
                                ->select(DB::raw("CONCAT(activities.name,' ',activities.description) AS name"), 'activities.id')
                                ->pluck('name', 'activities.id');

        $student = Student::join('users', 'students.user_id', '=', 'users.id')
                            ->where('users.id', '=', $user)
                            ->pluck('users.name', 'students.id');

        return view('schoolworks.create', ['activities' => $activities, 'student' => $student]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreSchoolworkRequest $request)
    {
        $schoolwork = $request->except('_token');
        $schoolwork['uuid'] = (string) Str::uuid();
        if ($request->hasFile('homework')) {
            $file = $request->file('homework')->getClientOriginalName();
            $schoolwork['homework'] = $request->file('homework')
                                            ->storeAs(
                                                        'schoolworks/'.$request->student_id,
                                                        $file,
                                                        'public'
                                                    );
        }
        Schoolwork::insert($schoolwork);
        Flash::success('Tarea creada exitosamente.');
        return redirect()->route('schoolworks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schoolwork  $schoolwork
     * @return \Illuminate\Http\Response
     */
    public function show(/*Schoolwork $schoolwork*/ $id)
    {
        $schoolwork = Schoolwork::findOrFail($id);
        return view('schoolworks.show', ['schoolwork' => $schoolwork]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schoolwork  $schoolwork
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Schoolwork $schoolwork*/ $id)
    {
        $user = Auth::id();
        $in_session_user = User::findOrFail($user);
        $schoolwork = Schoolwork::findOrFail($id);

        if ($in_session_user->hasRole(['Administrador'])) {
            $activities = Activity::join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                                    ->where('schoolworks.id', $id)->pluck('activities.name', 'activities.id');
            $student = Student::join('users', 'students.user_id', '=', 'users.id')
                                    ->join('schoolworks', 'schoolworks.student_id', '=', 'students.id')
                                    ->where('schoolworks.id', $id)->pluck('users.name', 'users.id');
        }

        if ($in_session_user->hasRole(['Docente'])) {
            $activities = Activity::join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                                    ->where('schoolworks.id', $id)->pluck('activities.name', 'activities.id');
            $student = Student::join('users', 'students.user_id', '=', 'users.id')
                                    ->join('schoolworks', 'schoolworks.student_id', '=', 'students.id')
                                    ->where('schoolworks.id', $id)->pluck('users.name', 'users.id');
        }

        if ($in_session_user->hasRole(['Estudiante'])) {

            $activity = Activity::join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                                    ->where('schoolworks.id', $id)
                                    ->pluck('activities.deadline')
                                    ->implode('');
            $now = Carbon::now()->toDateTimeString();

            if ($activity <= $now or $schoolwork['score'] != null) {
                Flash::error('No puede editar la tarea');
                return redirect()->route('schoolworks.index');
            } else {
                $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                        ->join('classrooms', 'teachers.classroom_id', '=', 'classrooms.id')
                                        ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                                        ->join('users', 'students.user_id', '=', 'users.id')
                                        ->where('users.id', '=', $user)
                                        ->where('activities.status', '=', 'Activa')
                                        ->where('activities.deadline', '>', Carbon::now())
                                        ->select(DB::raw("CONCAT(teachers.class_name,' ',activities.name) AS name"), 'activities.id')
                                        ->pluck('name', 'activities.id');
                $student = Student::join('users', 'students.user_id', '=', 'users.id')
                                    ->where('users.id', '=', $user)->pluck('users.name', 'students.id');

            }
        }
        return view('schoolworks.edit', ['schoolwork' => $schoolwork, 'activities' => $activities, 'student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schoolwork  $schoolwork
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateSchoolworkRequest $request, /*Schoolwork $schoolwork*/ $id)
    {
        $user = Auth::id();
        $in_session_user = User::findOrFail($user);
        if ($in_session_user->hasRole(['Docente'])) {
            $schoolwork = $request->except('_token', '_method', 'homework', 'activity_id', 'student_id');
            $unranked_schoolwork = Schoolwork::findOrFail($id);
            if ($schoolwork['score'] == null and $unranked_schoolwork['score'] == null) {
                Flash::error('No puede guardar la tarea sin calificar');
                return back();
            }
            if ($schoolwork['score'] != null and $unranked_schoolwork['score'] == null) {
                $schoolwork['scored_at'] = Carbon::now(); // Las tareas deben tener la fecha en que se calificaron.
            }
            if ($schoolwork['score'] == null and $unranked_schoolwork['score'] != null) {
                Flash::error('No puede guardar la tarea sin calificar');
                return back();
            }
            if ($schoolwork['score'] != null and $unranked_schoolwork['score'] != null) {
                $schoolwork['modified_at'] = Carbon::now();
            }
        } else {
            $schoolwork = $request->except('_token', '_method', 'scored_at');
            $schoolwork['uuid'] = (string) Str::uuid();
            if ($request->hasFile('homework')) {
                $file = $request->file('homework')->getClientOriginalName();
                $schoolwork['homework'] = $request->file('homework')
                                                ->storeAs(
                                                            'schoolworks/'.$request->student_id,
                                                            $file,
                                                            'public'
                                                        );
            }
        }
        Schoolwork::where('id', '=', $id)->update($schoolwork);
        Flash::success('Tarea actualizada exitosamente.');
        return redirect()->route('schoolworks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schoolwork  $schoolwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Schoolwork $schoolwork*/ $id)
    {
        $user = Auth::id();
        $in_session_user = User::findOrFail($user);
        $schoolwork = Schoolwork::findOrFail($id);

        if ($in_session_user->hasRole(['Estudiante'])) {

            $activity = Activity::join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                                    ->where('schoolworks.id', $id)
                                    ->pluck('activities.deadline')
                                    ->implode('');
            $now = Carbon::now()->toDateTimeString();

            if ($activity <= $now or $schoolwork['score'] != null) {
                Flash::error('No puede borrar la tarea');
            }
            else {
                Schoolwork::destroy($id);
                Flash::success('Tarea borrada exitosamente.');
            }
        }
        return redirect()->route('schoolworks.index');
    }

    public function download($uuid)
    {
        $schoolwork = Schoolwork::where('uuid', '=', $uuid)->firstOrFail();
        $file = storage_path('app/public/'.$schoolwork->homework);
        return response()->download($file);
    }
}
