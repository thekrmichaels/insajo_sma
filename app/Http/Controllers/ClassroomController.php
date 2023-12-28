<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;

use Flash;

class ClassroomController extends Controller
{
    public function __construct()
    {
        // $this->middleware(can:'route_name.method')->only('method');
        $this->middleware('can:classrooms.index')->only('index');
        $this->middleware('can:classrooms.create')->only('create');
        $this->middleware('can:classrooms.edit')->only('edit');
        $this->middleware('can:classrooms.store')->only('store');
        $this->middleware('can:classrooms.show')->only('show');
        $this->middleware('can:classrooms.update')->only('update');
        $this->middleware('can:classrooms.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $classrooms = DB::table('classrooms')
                        ->where('name', 'LIKE', '%'.$search.'%')
                        ->select('id', 'name')
                        ->get();
        return view('classrooms.index', ['classrooms' => $classrooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreClassroomRequest $request)
    {
        $classroom = $request->all();
        Classroom::insert($classroom);
        Flash::success('Curso creado exitosamente.');
        return redirect()->route('classrooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(/*Classroom $classroom*/ $id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classrooms.show', ['classroom' => $classroom]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Classroom $classroom*/ $id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classrooms.edit', ['classroom' => $classroom]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request /*UpdateClassroomRequest*/, Classroom $classroom /*$id*/)
    {
        DB::table('classrooms')
            ->where('id', '=', $classroom['id'])
            ->update($request->except('_token', '_method'));
        Flash::success('Curso actualizado exitosamente.');
        return redirect()->route('classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Classroom $classroom*/ $id)
    {
        Classroom::destroy($id);
        Flash::success('Curso borrado exitosamente.');
        return redirect()->route('classrooms.index');
    }
}
