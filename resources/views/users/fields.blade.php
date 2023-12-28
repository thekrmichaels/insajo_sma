<div class="form-group col-sm-6">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ isset($user) ? $user->name : '' }}">
</div>
<div class="form-group col-sm-6">
    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" class="form-control" value="{{ isset($user) ? $user->email : '' }}">
</div>
<div class="form-group col-sm-6">
    <label for="password">Contraseña:</label>
    <input type="password" name="password" class="form-control">
</div>
<div class="form-group col-sm-6">
    <label for="status">Estado:</label>
    <select name="status" class="form-control" id="status">
        @if (!isset($user))
            <option value="">Seleccione un estado</option>
        @endif
        <option value="Habilitado" {{ isset($user) && $user->status == 'Habilitado' ? 'selected' : '' }}>Habilitado
        </option>
        <option value="Deshabilitado" {{ isset($user) && $user->status == 'Deshabilitado' ? 'selected' : '' }}>Deshabilitado
        </option>
    </select>
</div>
<div class="form-group col-sm-6">
    <label for="role_id">Rol:</label>
    <select name="roles" class="form-control">
        @if (!isset($user))
            <option value="">Seleccione un rol</option>
        @endif
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" {{ isset($user) && $user->hasRole($role) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>
</div>
