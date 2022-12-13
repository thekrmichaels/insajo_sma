@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Cursos</h1>
                </div>

                <div class="col-sm-6">
                    <form action="{{ route('classrooms.index') }}" method="GET">
                        <div class="form-row justify-content-center">
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="search">
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-primary" value="Buscar">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-3">
                    <a class="btn btn-primary float-right" href="{{ route('classrooms.create') }}">
                        Crear Nuevo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('classrooms.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
