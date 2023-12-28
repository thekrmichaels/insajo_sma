<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Classroom;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

use Flash;

class StudentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(can:'route_name.method')->only('method');
        $this->middleware('can:students.index')->only('index');
        $this->middleware('can:students.create')->only('create');
        $this->middleware('can:students.edit')->only('edit');
        $this->middleware('can:students.store')->only('store');
        $this->middleware('can:students.show')->only('show');
        $this->middleware('can:students.update')->only('update');
        $this->middleware('can:students.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::query()
                            ->with(['user', 'classroom'])
                            ->when(request('search'), function($query) {
                                return $query->whereHas('user', function ($query) {
                                    $query->where('name', 'LIKE', '%'.request('search').'%');
                                })
                                ->orWhereHas('classroom', function ($query2) {
                                    $query2->where('name', 'LIKE', '%'.request('search').'%');
                                });
                            })->orderBy('id', 'asc')->paginate();
        return view('students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::role('Estudiante')->pluck('name', 'id');
        $classrooms = Classroom::pluck('name', 'id');
        return view('students.create', ['users' => $users, 'classrooms' => $classrooms]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreStudentRequest $request)
    {

        $student = $request->except('_token');
        Student::insert($student);
        Flash::success('Estudiante creado exitosamente.');
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(/*Student $student*/ $id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Student $student*/ $id)
    {
        $student = Student::findOrFail($id);
        $users = User::role('Estudiante')->pluck('name', 'id');
        $classrooms = Classroom::pluck('name', 'id');
        return view('students.edit', ['student' => $student, 'users' => $users, 'classrooms' => $classrooms]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateStudentRequest $request, /*Student $student*/ $id)
    {
        $student = $request->except('_token', '_method');
        Student::where('id', '=', $id)->update($student);
        Flash::success('Estudiante actualizado exitosamente.');
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Student $student*/ $id)
    {
        Student::destroy($id);
        Flash::success('Estudiante borrado exitosamente.');
        return redirect()->route('students.index');
    }
}
