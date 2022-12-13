<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Correo Electrónico:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- Email Verified At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email_verified_at', 'Email Verified At:') !!}
        {!! Form::text('email_verified_at', null, ['class' => 'form-control','id'=>'email_verified_at']) !!}
    </div>

    @push('page_scripts')
        <script type="text/javascript">
            $('#email_verified_at').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                sideBySide: true
            })
        </script>
    @endpush --}}

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Contraseña:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!--
    Remember Token Field
    <div class="form-group col-sm-6">
        {{-- {!! Form::label('remember_token', 'Remember Token:') !!} --}}
        {{-- {!! Form::text('remember_token', null, ['class' => 'form-control']) !!} --}}
    </div>
-->

<div class="form-group col-sm-6">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', ['Habilitado' => 'Habilitado', 'Deshabilitado' => 'Deshabilitado'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione un estado']) !!}
</div>
