@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 text-center">
                <div class="col-sm-9">
                    <h1 align="left">Usuarios</h1>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-primary float-right"
                        onclick="window.location.href='{{ route('users.create') }}'">Crear Nuevo</button>
                </div>
            </div>
        </div>
    </section>
    <div class="content px-3">
        @include('flash::message')
        <div class="card">
            <div class="card-body p-0">
                @include('users.table')
            </div>
        </div>
    </div>
@endsection
