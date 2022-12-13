<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

use Flash;

class SubjectController extends Controller
{
    public function __construct()
    {
        // $this->middleware(can:'route_name.method')->only('method');
        $this->middleware('can:subjects.index')->only('index');
        $this->middleware('can:subjects.create')->only('create');
        $this->middleware('can:subjects.edit')->only('edit');
        $this->middleware('can:subjects.store')->only('store');
        $this->middleware('can:subjects.show')->only('show');
        $this->middleware('can:subjects.update')->only('update');
        $this->middleware('can:subjects.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $subjects = DB::table('subjects')
                        ->where('name', 'LIKE', '%'.$search.'%')
                        ->select('id', 'name')
                        ->get();
        return view('subjects.index', ['subjects' => $subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(/*Request*/ StoreSubjectRequest $request)
    {
        $subject = $request->except('_token');
        Subject::insert($subject);
        Flash::success('Asignatura creada exitosamente.');
        return redirect()->route('subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(/*Subject $subject*/ $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.show', ['subject' => $subject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(/*Subject $subject*/ $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', ['subject' => $subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/ UpdateSubjectRequest $request, /*Subject $subject*/ $id)
    {
        $subject = $request->except('_token', '_method');
        Subject::where('id', '=', $id)->update($subject);
        Flash::success('Asignatura actualizada exitosamente.');
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*Subject $subject*/ $id)
    {
        Subject::destroy($id);
        Flash::success('Asignatura borrada exitosamente.');
        return redirect()->route('subjects.index');
    }
}
