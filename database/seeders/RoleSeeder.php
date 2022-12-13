<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role; // Hace referencia al modelo Rol de Spatie.
use Spatie\Permission\Models\Permission; // Hace referencia al modelo Permiso de Spatie.

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Administrador']);
        $teacher = Role::create(['name' => 'Docente']);
        $student = Role::create(['name' => 'Estudiante']);

        Permission::create(['name' => 'home'])->syncRoles($admin, $student, $teacher);

        Permission::create(['name' => 'classrooms.index'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.create'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.store'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.show'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.edit'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.update'])->syncRoles($admin);
        Permission::create(['name' => 'classrooms.destroy'])->syncRoles($admin);

        Permission::create(['name' => 'subjects.index'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.create'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.store'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.show'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.edit'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.update'])->syncRoles($admin);
        Permission::create(['name' => 'subjects.destroy'])->syncRoles($admin);

        Permission::create(['name' => 'users.index'])->syncRoles($admin);
        Permission::create(['name' => 'users.create'])->syncRoles($admin);
        Permission::create(['name' => 'users.store'])->syncRoles($admin);
        Permission::create(['name' => 'users.show'])->syncRoles($admin);
        Permission::create(['name' => 'users.edit'])->syncRoles($admin);
        Permission::create(['name' => 'users.update'])->syncRoles($admin);
        Permission::create(['name' => 'users.destroy'])->syncRoles($admin);

        Permission::create(['name' => 'students.index'])->syncRoles($admin);
        Permission::create(['name' => 'students.create'])->syncRoles($admin);
        Permission::create(['name' => 'students.store'])->syncRoles($admin);
        Permission::create(['name' => 'students.show'])->syncRoles($admin);
        Permission::create(['name' => 'students.edit'])->syncRoles($admin);
        Permission::create(['name' => 'students.update'])->syncRoles($admin);
        Permission::create(['name' => 'students.destroy'])->syncRoles($admin);

        Permission::create(['name' => 'teachers.index'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.create'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.store'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.show'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.edit'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.update'])->syncRoles($admin);
        Permission::create(['name' => 'teachers.destroy'])->syncRoles($admin);

        Permission::create(['name' => 'activities.index'])->syncRoles($admin, $teacher, $student);
        Permission::create(['name' => 'activities.create'])->syncRoles($teacher);
        Permission::create(['name' => 'activities.store'])->syncRoles($teacher);
        Permission::create(['name' => 'activities.show'])->syncRoles($admin, $teacher, $student);
        Permission::create(['name' => 'activities.edit'])->syncRoles($teacher);
        Permission::create(['name' => 'activities.update'])->syncRoles($teacher);
        Permission::create(['name' => 'activities.destroy'])->syncRoles($teacher);

        Permission::create(['name' => 'schoolworks.index'])->syncRoles($admin, $student, $teacher);
        Permission::create(['name' => 'schoolworks.create'])->syncRoles($student);
        Permission::create(['name' => 'schoolworks.store'])->syncRoles($student, $teacher);
        Permission::create(['name' => 'schoolworks.show'])->syncRoles($admin, $student, $teacher);
        Permission::create(['name' => 'schoolworks.edit'])->syncRoles($student, $teacher);
        Permission::create(['name' => 'schoolworks.update'])->syncRoles($student, $teacher);
        Permission::create(['name' => 'schoolworks.destroy'])->syncRoles($student);

        Permission::create(['name' => 'update score'])->syncRoles($teacher);
    }
}
