<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Estudiante:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un estudiante']) !!}
</div>

<!-- Classroom Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('classroom_id', 'Curso:') !!}
    {!! Form::select('classroom_id', $classrooms, null, ['class' => 'form-control', 'placeholder' => 'Ninguno']) !!}
</div>
