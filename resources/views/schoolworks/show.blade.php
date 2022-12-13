@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles de la Tarea</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('schoolworks.index') }}">
                        Atrás
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('schoolworks.show_fields')
                </div>
            </div>
        </div>
    </div>
    @include('comments.list2', ['comments' => $schoolwork->comments])
    @include('comments.form2')
@endsection
