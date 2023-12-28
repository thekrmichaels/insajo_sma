<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Activity;
use Flash;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;

class TeacherController extends Controller
{
    public function __construct()
    {
        // $this->middleware(can:'route_name.method')->only('method');
        $this->middleware('can:teachers.index')->only('index');
        $this->middleware('can:teachers.create')->only('create');
        $this->middleware('can:teachers.edit')->only('edit');
        $this->middleware('can:teachers.store')->only('store');
        $this->middleware('can:teachers.show')->only('show');
        $this->middleware('can:teachers.update')->only('update');
        $this->middleware('can:teachers.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()
                            ->with(['user', 'subject', 'classroom'])
                            ->when(request('search'), function($query) {
                                return $query->where('class_name', 'LIKE', '%'.request('search').'%');
                            })
                            ->orWhereHas('user', function ($query2) {
                                $query2->where('name', 'LIKE', '%'.request('search').'%');
                            })
                            ->orWhereHas('subject', function ($query3) {
                                $query3->where('name', 'LIKE', '%'.request('search').'%');
                            })
                            ->orWhereHas('classroom', function ($query4) {
                                $query4->where('name', 'LIKE', '%'.request('search').'%');
                            })->orderBy('id', 'asc')->paginate();
        return view('teachers.index', ['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::role('Docente')->pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        $classrooms = Classroom::pluck('name', 'id');
        return view('teachers.create', ['users' => $users, 'subjects' => $subjects, 'classrooms' => $classrooms]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreTeacherRequest $request)
    {
        $teacher = $request->except('_token');
        $user = User::where('id', '=', $teacher['user_id'])->pluck('name')->implode('');
        $subject = Subject::where('id', '=', $teacher['subject_id'])->pluck('name')->implode('');
        $classroom = Classroom::where('id', '=', $teacher['classroom_id'])->pluck('name')->implode('');
        $teacher['class_name'] = $user." - ".$subject." - ".$classroom;
        $existing_teacher = Teacher::where('user_id', '=', $teacher['user_id'])
                                    ->where('subject_id', '=', $teacher['subject_id'])
                                    ->where('classroom_id', '=', $teacher['classroom_id'])
                                    ->count();
        if ($existing_teacher > 0) {
            Flash::error('Ya existe el docente con esa descripción');
        } else {
            Teacher::insert($teacher);
            Flash::success('Docente creado exitosamente.');
        }
        return redirect()->route('teachers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(/*Teacher $teacher*/ $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.show', ['teacher' => $teacher]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Teacher $teacher*/ $id)
    {
        $teacher = Teacher::findOrFail($id);
        $users = User::role('Docente')->pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        $classrooms = Classroom::pluck('name', 'id');
        return view('teachers.edit', ['teacher' => $teacher, 'users' => $users, 'subjects' => $subjects, 'classrooms' => $classrooms]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateTeacherRequest $request, /*Teacher $teacher*/ $id)
    {
        $teacher = $request->except('_token', '_method');
        $user = User::where('id', '=', $teacher['user_id'])->pluck('name')->implode('');
        $subject = Subject::where('id', '=', $teacher['subject_id'])->pluck('name')->implode('');
        $classroom = Classroom::where('id', '=', $teacher['classroom_id'])->pluck('name')->implode('');
        $teacher['class_name'] = $user."  ".$subject."  ".$classroom;
        $existing_teacher = Teacher::where('user_id', '=', $teacher['user_id'])
                                    ->where('subject_id', '=', $teacher['subject_id'])
                                    ->where('classroom_id', '=', $teacher['classroom_id'])
                                    ->count();
        if ($existing_teacher > 0) {
            Flash::error('Ya existe el docente con esa descripción');
        } else {
            Teacher::where('id', '=', $id)->update($teacher);
            Flash::success('Docente actualizado exitosamente.');
        }
        return redirect()->route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Teacher $teacher*/ $id)
    {
        $activities = Activity::join('teachers', 'activities.teacher_id', '=', 'teachers.id')
                                ->where('teachers.id', $id)
                                ->count();

        if ($activities > 0) {
            Flash::error('No puede borrar el docente');
        } else {
            Teacher::destroy($id);
            Flash::success('Docente borrado exitosamente.');
        }
        return redirect()->route('teachers.index');
    }
}
