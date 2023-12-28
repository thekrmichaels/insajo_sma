<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->first() }}</td>
                    <td>{{ $user->status }}</td>
                    <td width="120">
                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class='btn-group'>
                                <button type="button" class="btn btn-default btn-xs"
                                    onclick="window.location.href='{{ route('users.show', [$user->id]) }}'"><i
                                        class="far fa-eye"></i></button>
                                <button type="button" class="btn btn-default btn-xs"
                                    onclick="window.location.href='{{ route('users.edit', [$user->id]) }}'"><i
                                        class="far fa-edit"></i></button>
                                <button type="submit" class="btn btn-danger btn-xs"
                                    onclick="return confirm('¿Está seguro?')">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
