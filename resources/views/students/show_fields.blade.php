<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'Estudiante:') !!}
    <p>{{ $student->user->name }}</p>
</div>

<!-- Classroom Id Field -->
<div class="col-sm-12">
    {!! Form::label('classroom_id', 'Curso:') !!}
    <p>{{ $student->classroom->name ?? 'Ninguno'}}</p>
</div>

