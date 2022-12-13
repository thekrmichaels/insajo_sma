<!-- Activity Id Field -->
<div class="col-sm-12">
    {!! Form::label('activity_id', 'Actividad:') !!}
    <p>{{ $schoolwork->activity->name }}</p>
</div>

<!-- Teacher Id Field -->
<div class="col-sm-12">
    {!! Form::label('teacher_id', 'Docente:') !!}
    <p>{{ $schoolwork->activity->teacher->user->name }}</p>
</div>

<!-- Student Id Field -->
<div class="col-sm-12">
    {!! Form::label('student_id', 'Estudiante:') !!}
    <p>{{ $schoolwork->student->user->name }}</p>
</div>

<!-- Classroom Id Field -->
<div class="col-sm-12">
    {!! Form::label('classroom_id', 'Curso:') !!}
    <p>{{ $schoolwork->student->classroom->name }}</p>
</div>

<!-- Homework Field -->
<div class="col-sm-12">
    {!! Form::label('homework', 'Tarea:') !!}
    <br>
    {{--<p>{{ $schoolwork->homework }}</p>--}}
    <a href="{{ route('schoolworks.download', $schoolwork->uuid) }}">{{ $schoolwork->homework }}</a>
</div>

<!-- Sent At Field -->
<div class="col-sm-12">
    {!! Form::label('sent_at', 'Enviada a las:') !!}
    <p>{{ $schoolwork->sent_at }}</p>
</div>

<!-- Score Field -->
<div class="col-sm-12">
    {!! Form::label('score', 'Calificación:') !!}
    <p>{{ $schoolwork->score }}</p>
</div>

<!-- Scored At Field -->
<div class="col-sm-12">
    {!! Form::label('scored_at', 'Calificada a las:') !!}
    <p>{{ $schoolwork->scored_at }}</p>
</div>
