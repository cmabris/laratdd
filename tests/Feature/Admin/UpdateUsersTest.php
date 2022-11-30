<?php

namespace Tests\Feature\Admin;

use App\Profession;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Pepe',
        'email' => 'pepe@mail.es',
        'password' => '12345678',
        'profession_id' => '',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/pepe',
        'role' => 'user',
    ];

    /** @test */
    function it_loads_the_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get('usuarios/'.$user->id.'/editar')
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id;
            });
    }

    /** @test */
    function it_updates_a_user()
    {
        $user = factory(User::class)->create();

        $this->put('usuarios/'.$user->id, [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ])->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ]);
    }

    /** @test */
    function the_name_is_required()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => '',
                'email' => 'pepe@mail.es',
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'pepe@mail.es']);
    }

    /** @test */
    function the_email_is_required()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => '',
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    function the_email_must_be_valid()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => 'correo-no-valido',
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    function the_email_must_be_unique()
    {
        $this->withExceptionHandling();

        factory(User::class)->create([
            'email' => 'existing-email@mail.es'
        ]);

        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es'
        ]);

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => 'existing-email@mail.es',
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id . '/editar')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Pepe']);
    }

    /** @test */
    function the_user_email_can_stay_the_same()
    {
        $this->withExceptionHandling();
        
        $user = factory(User::class)->create([
            'email' => 'pepe@mail.es'
        ]);

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id);

        $this->assertDatabaseHas('users', [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
        ]);
    }

    /** @test */
    function the_password_is_optional()
    {
        $oldPassword = 'CLAVE_VIEJA';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword),
        ]);

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '',
            ])->assertRedirect('usuarios/' . $user->id);

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => $oldPassword,
        ]);
    }
}
