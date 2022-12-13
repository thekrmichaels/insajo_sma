<!-- Class Name Field -->
<div class="col-sm-12">
    {!! Form::label('class_name', 'Clase:') !!}
    <p>{{ $teacher->class_name }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'Docente:') !!}
    <p>{{ $teacher->user->name ?? 'Ninguno'}}</p>
</div>

<!-- Subject Id Field -->
<div class="col-sm-12">
    {!! Form::label('subject_id', 'Asignatura:') !!}
    <p>{{ $teacher->subject->name ?? 'Ninguno'}}</p>
</div>

<!-- Classroom Id Field -->
<div class="col-sm-12">
    {!! Form::label('classroom_id', 'Curso:') !!}
    <p>{{ $teacher->classroom->name ?? 'Ninguno'}}</p>
</div>
