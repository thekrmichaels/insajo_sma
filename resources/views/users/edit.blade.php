@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Editar Usuario</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                <div class="card-body">
                    <div class="row">
                        @include('users.fields')

                        <!-- Role Field -->
                        <div class="form-group col-sm-6">
                            <label for="role_id">Rol:</label>
                            <select class="form-control" name="roles[]">
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancelar</a>
                </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
