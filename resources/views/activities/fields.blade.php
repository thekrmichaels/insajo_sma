<!-- Teacher Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('teacher_id', 'Clase:') !!}
    {!! Form::select('teacher_id', $classes, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una clase']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', ['Activa' => 'Activa', 'Inactiva' => 'Inactiva'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione un estado']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5' ]) !!}
</div>

<!-- Since Field -->
<div class="form-group col-sm-6">
    {!! Form::label('since', 'Desde:') !!}
    {!! Form::text('since', null, ['class' => 'form-control', 'id' => 'since']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#since').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', 'Hasta:') !!}
    {!! Form::text('deadline', null, ['class' => 'form-control', 'id' => 'deadline']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#deadline').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Homework Field -->
<div class="form-group col-sm-6">
    {!! Form::label('homework', 'Material:') !!}
    {!! Form::file('homework', ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Enlace:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>
