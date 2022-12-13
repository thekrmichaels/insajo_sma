<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Correo Electrónico:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Role Field -->
<div class="col-sm-12">
    {!! Form::label('role', 'Rol:') !!}
    <p>{{ $role }}</p>
</div>

<!--
    Email Verified At Field
    <div class="col-sm-12">
        {{-- {!! Form::label('email_verified_at', 'Email Verified At:') !!} --}}
        <p> {{-- {{ $user->email_verified_at }} --}} </p>
    </div>
-->

<!--
    Password Field
    <div class="col-sm-12">
        {{-- {!! Form::label('password', 'Password:') !!} --}}
        <p> {{-- {{ $user->password }} --}} </p>
    </div>
-->

<!--
    Remember Token Field
    <div class="col-sm-12">
        {{-- {!! Form::label('remember_token', 'Remember Token:') !!} --}}
        <p> {{-- {{ $user->remember_token }} --}} </p>
    </div>
-->

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Estado:') !!}
    <p>{{ $user->status }}</p>
</div>