<!-- Activity Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('activity_id', 'Actividad:') !!}
    {!! Form::select('activity_id', $activities, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una actividad']) !!}
</div>

<!-- Student Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('student_id', 'Estudiante:') !!}
    {!! Form::select('student_id', $student, null, ['class' => 'form-control']) !!}
</div>

<!-- Homework Field -->
@unlessrole('Docente')
    <div class="form-group col-sm-6">
        {!! Form::label('homework', 'Tarea:') !!}
        {!! Form::file('homework', ['class' => 'form-control ']) !!}
    </div>
@endunlessrole

<!--
    Sent At Field
    <div class="form-group col-sm-6">
        {{-- {!! Form::label('sent_at', 'Enviada a las:') !!} --}}
        {{-- {!! Form::text('sent_at', null, ['class' => 'form-control','id'=>'sent_at']) !!} --}}
    </div>
-->

{{-- @push('page_scripts')
        <script type="text/javascript">
            $('#sent_at').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                sideBySide: true
            })
        </script>
    @endpush --}}

<!-- Score Field -->
@unlessrole('Estudiante')
    <div class="form-group col-sm-6">
        <label for="score">Calificación:</label>
        <input type="number" step="0.1" name="score" min="0" max="5" class="form-control" />
    </div>
@endunlessrole
