<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@insajo.edu.co',
            'password' => bcrypt('PostmodernJukebox'),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Docente 1',
            'email' => 'docente1@insajo.edu.co',
            'password' => bcrypt('12345678'),
        ])->assignRole('Docente');

        User::create([
            'name' => 'Docente 2',
            'email' => 'docente2@insajo.edu.co',
            'password' => bcrypt('12345678'),
        ])->assignRole('Docente');

        User::create([
            'name' => 'Estudiante 1',
            'email' => 'estudiante1@insajo.edu.co',
            'password' => bcrypt('12345678'),
        ])->assignRole('Estudiante');

        User::create([
            'name' => 'Estudiante 2',
            'email' => 'estudiante2@insajo.edu.co',
            'password' => bcrypt('12345678'),
        ])->assignRole('Estudiante');

        Classroom::create([
            'name' => 'Classroom 1',
        ]);

        Classroom::create([
            'name' => 'Classroom 2',
        ]);

        Subject::create([
            'name' => 'Subject 1',
        ]);

        Subject::create([
            'name' => 'Subject 2',
        ]);

        Teacher::create([
            'class_name' => 'Class 1',
            'user_id' => '2',
            'subject_id' => '1',
            'classroom_id' => '1',
        ]);

        Teacher::create([
            'class_name' => 'Class 2',
            'user_id' => '3',
            'subject_id' => '2',
            'classroom_id' => '2',
        ]);

        Student::create([
            'user_id' => '4',
            'classroom_id' => '1',
        ]);

        Student::create([
            'user_id' => '5',
            'classroom_id' => '2',
        ]);
    }
}
