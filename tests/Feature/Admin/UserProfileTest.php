<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\User;
use App\UserProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'first_name' => 'Pepe',
        'last_name' => 'Pérez',
        'email' => 'pepe@mail.es',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/pepe',
    ];

    /** @test */
    function a_user_can_edit_its_profile()
    {
        $user = factory(User::class)->create();

        $newProfession = factory(Profession::class)->create();

        $response = $this->get('editar-perfil');
        $response->assertStatus(200);

        $response = $this->put('editar-perfil', [
            'first_name' => 'Pepe',
            'last_name' => 'Pérez',
            'email' => 'pepe@mail.es',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);

        $response->assertRedirect('editar-perfil');

        $this->assertDatabaseHas('users', [
            'first_name' => 'Pepe',
            'last_name' => 'Pérez',
            'email' => 'pepe@mail.es',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'profession_id' => $newProfession->id,
        ]);
    }

    /** @test */
    function the_user_cannot_change_its_role()
    {
        $user = factory(User::class)->create([
            'role' => 'user',
        ]);

        $response = $this->put('editar-perfil', $this->getValidData([
            'role' => 'admin',
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
        ]);
    }

    /** @test */
    function the_user_cannot_change_its_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('old123'),
        ]);

        $response = $this->put('editar-perfil', $this->getValidData([
            'email' => 'pepe@mail.es',
            'password' => 'new456',
        ]));

        $response->assertRedirect();

        $this->assertCredentials([
            'email' => 'pepe@mail.es',
            'password' => 'old123',
        ]);
    }
}
