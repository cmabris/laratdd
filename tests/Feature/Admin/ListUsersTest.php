<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_loads_the_users_list_page()
    {
        factory(User::class)->create([
            'first_name' => 'Joel'
        ]);

        factory(User::class)->create([
            'first_name' => 'Ellie'
        ]);

        $this->get('usuarios')
            ->assertStatus(200)
            ->assertSee(trans('users.title.index'))
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /** @test  */
    function it_shows_a_default_page_if_the_users_list_is_empty()
    {
        $this->get('usuarios?empty')
            ->assertStatus(200)
            ->assertSee('Usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    function it_shows_the_deleted_users()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'deleted_at' => now()
        ]);
        factory(User::class)->create([
            'first_name' => 'Ellie'
        ]);

        $this->get('usuarios/papelera')
            ->assertStatus(200)
            ->assertSee(trans('users.title.trash'))
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    function it_paginates_the_users()
    {
        factory(User::class)->create([
            'first_name' => 'Tercer usuario',
            'created_at' => now()->subDays(5),
        ]);
        factory(User::class)->times(12)->create([
            'created_at' => now()->subDays(4),
        ]);
        factory(User::class)->create([
            'first_name' => 'Decimoséptimo usuario',
            'created_at' => now()->subDays(2),
        ]);
        factory(User::class)->create([
            'first_name' => 'Segundo usuario',
            'created_at' => now()->subDays(6),
        ]);
        factory(User::class)->create([
            'first_name' => 'Primer usuario',
            'created_at' => now()->subWeek(),
        ]);
        factory(User::class)->create([
            'first_name' => 'Decimosexto usuario',
            'created_at' => now()->subDays(3),
        ]);

        $this->get('usuarios')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Decimoséptimo usuario',
                'Decimosexto usuario',
                'Tercer usuario',
            ])
            ->assertDontSee('Segundo usuario')
            ->assertDontSee('Primer usuario');

        $this->get('usuarios?page=2')
            ->assertSeeInOrder([
                'Segundo usuario',
                'Primer usuario',
            ])
            ->assertDontSee('Tercer usuario');
    }
}
