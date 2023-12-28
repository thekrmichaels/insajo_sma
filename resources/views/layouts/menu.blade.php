@can('users.index')
    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-users"></i>
                <p>&nbsp; Gestión de Usuarios</p>
            </font>
        </a>
    </li>
@endcan

@can('classrooms.index')
    <li class="nav-item">
        <a href="{{ route('classrooms.index') }}" class="nav-link {{ Request::is('classrooms*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-chalkboard"></i>
                <p>&nbsp; Gestión de Cursos</p>
            </font>
        </a>
    </li>
@endcan

@can('subjects.index')
    <li class="nav-item">
        <a href="{{ route('subjects.index') }}" class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-book"></i>
                <p>&nbsp; Asignaturas</p>
            </font>
        </a>
    </li>
@endcan

@can('teachers.index')
    <li class="nav-item">
        <a href="{{ route('teachers.index') }}" class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-chalkboard-teacher"></i>
                <p>&nbsp; Docentes</p>
            </font>
        </a>
    </li>
@endcan

@can('students.index')
    <li class="nav-item">
        <a href="{{ route('students.index') }}" class="nav-link {{ Request::is('students*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-user-friends"></i>
                <p>&nbsp; Estudiantes</p>
            </font>
        </a>
    </li>
@endcan

@can('activities.index')
    <li class="nav-item">
        <a href="{{ route('activities.index') }}" class="nav-link {{ Request::is('activities*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-list-ol"></i>
                <p>&nbsp; Actividades</p>
            </font>
        </a>
    </li>
@endcan

@can('schoolworks.index')
    <li class="nav-item">
        <a href="{{ route('schoolworks.index') }}" class="nav-link {{ Request::is('schoolworks*') ? 'active' : '' }}">
            <font color="white">
                <i class="fas fa-tasks"></i>
                <p>&nbsp; Tareas</p>
            </font>
        </a>
    </li>
@endcan
