@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Crear Usuario</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="content px-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @include('users.fields')
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default"
                        onclick="window.location.href='{{ route('users.index') }}'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
