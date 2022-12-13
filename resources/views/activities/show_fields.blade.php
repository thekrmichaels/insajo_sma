<!-- Teacher Id Field -->
<div class="col-sm-12">
    {!! Form::label('teacher_id', 'Clase:') !!}
    <p>{{ $activity->teacher->class_name ?? 'Ninguno'}}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Estado:') !!}
    <p>{{ $activity->status }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $activity->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{{ $activity->description }}</p>
</div>

<!-- Since Field -->
<div class="col-sm-12">
    {!! Form::label('since', 'Desde:') !!}
    <p>{{ $activity->since }}</p>
</div>

<!-- Deadline Field -->
<div class="col-sm-12">
    {!! Form::label('deadline', 'Hasta:') !!}
    <p>{{ $activity->deadline }}</p>
</div>

<!-- Homework Field -->
<div class="col-sm-12">
    {!! Form::label('homework', 'Material:') !!}
    <br>
    {{--<p>{{ $activity->homework }}</p>--}}
    <a href="{{ route('activities.download', $activity->uuid) }}">{{ $activity->homework }}</a>
</div>

<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', 'Enlace:') !!}
    <p>{{ $activity->url }}</p>
</div>
