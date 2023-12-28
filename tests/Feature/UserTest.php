<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(1);
    }

    /**
     *
     * @return void
     * @test
     */
    public function login()
    {
        $response = $this->post('login', [
            'email' => 'admin@insajo.edu.co',
            'password' => 'PostmodernJukebox',
        ]);
        $response->assertRedirect('home');
    }

    /**
     *
     * @return void
     * @test
     */
    public function index()
    {
        $response = $this->actingAs($this->user, 'web')->get('users');
        $response->assertViewHasAll([
            'users',
        ]);
    }

    /**
     *
     * @return void
     * @test
     */
    public function create()
    {
        $response = $this->actingAs($this->user, 'web')->get('users/create');
        $response->assertViewHasAll([
            'roles',
        ]);
    }

    /**
     *
     * @return void
     * @test
     */
    public function store()
    {
        $response = $this->actingAs($this->user, 'web')->post('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@insajo.edu.co',
            'password' => '12345678',
            'status' => 'Habilitado',
            'roles' => [
                '*' => [
                    '2',
                ]
            ]
        ]);
        $response->assertRedirect('users');
    }

    /**
     *
     * @return void
     * @test
     */
    public function show()
    {
        $response = $this->actingAs($this->user, 'web')->get('users/1');
        $response->assertViewHasAll([
            'user',
            'role',
        ]);
    }

    /**
     *
     * @return void
     * @test
     */
    public function edit()
    {
        $response = $this->actingAs($this->user, 'web')->get('users/1/edit');
        $response->assertViewHasAll([
            'user',
            'roles',
        ]);
    }

    /**
     *
     * @return void
     * @test
     */
    public function update()
    {
        $response = $this->actingAs($this->user, 'web')->patch('users/2', [
            'name' => 'Jane Doe',
            'email' => 'janedoe@insajo.edu.co',
            'password' => '',
            'status' => 'Deshabilitado',
            'roles' => [
                '*' => [
                    '3',
                ]
            ]
        ]);
        $response->assertRedirect('users');
    }

    /**
     *
     * @return void
     * @test
     */
    public function destroy()
    {
        $response = $this->actingAs($this->user, 'web')->delete('users/1');
        $response->assertRedirect('users');
    }
}
