{{--
<!-- Class Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('class_name', 'Clase:') !!}
    {!! Form::text('class_name', null, ['class' => 'form-control']) !!}
</div>
--}}

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Docente:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => 'Ninguno']) !!}
</div>

<!-- Subject Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject_id', 'Asignatura:') !!}
    {!! Form::select('subject_id', $subjects, null, ['class' => 'form-control', 'placeholder' => 'Ninguno']) !!}
</div>

<!-- Classroom Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('classroom_id', 'Curso:') !!}
    {!! Form::select('classroom_id', $classrooms, null, ['class' => 'form-control', 'placeholder' => 'Ninguno']) !!}
</div>
