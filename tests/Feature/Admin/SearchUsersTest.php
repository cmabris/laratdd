<?php

namespace Tests\Feature\Admin;

use App\Team;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Livewire\GetsUserListComponent;
use Tests\TestCase;
use function foo\func;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase, GetsUserListComponent;

    /** @test */
    function search_users_by_full_name()
    {
        $joel = factory(User::class)->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);
        $ellie = factory(User::class)->create([
            'first_name' => 'Ellie',
            'last_name' => 'Miller',
        ]);

        $this->getUserListComponent(['search' => 'Joel Miller'])
            ->assertStatus(200)
            ->assertSee('Joel Miller')
            ->assertDontSee('Ellie Miller');
    }

    /** @test */
    function partial_search_by_full_name()
    {
        $joel = factory(User::class)->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);
        $ellie = factory(User::class)->create([
            'first_name' => 'Ellie',
            'last_name' => 'Miller',
        ]);

        $this->getUserListComponent(['search' => 'Jo'])
            ->assertStatus(200)
            ->assertSee('Joel Miller')
            ->assertDontSee('Ellie Miller');

    }

    /** @test */
    function search_users_by_email()
    {
        $joel = factory(User::class)->create([
            'email' => 'joel@example.com',
        ]);
        $ellie = factory(User::class)->create([
            'email' => 'ellie@example.com',
        ]);

        $this->getUserListComponent(['search' => 'joel@example.com'])
            ->assertStatus(200)
            ->assertSee('joel@example.com')
            ->assertDontSee('ellie@example.com');
    }

    /** @test */
    function show_results_with_a_partial_search_by_email()
    {
        $joel = factory(User::class)->create([
            'email' => 'joel@example.com',
        ]);
        $ellie = factory(User::class)->create([
            'email' => 'ellie@example.com',
        ]);

        $this->getUserListComponent(['search' => 'el@exam'])
            ->assertStatus(200)
            ->assertSee('joel@example.com')
            ->assertDontSee('ellie@example.com');
    }

    /** @test */
    function search_users_by_team_name()
    {
        $joel = factory(User::class)->create([
            'first_name' => 'Joel',
            'team_id' => factory(Team::class)->create([
                'name' => 'Smuggler'
            ])->id,
        ]);
        $ellie = factory(User::class)->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);
        $marlene = factory(User::class)->create([
            'first_name' => 'Marlene',
            'team_id' => factory(Team::class)->create([
                'name' => 'Firefly'
            ])->id,
        ]);

        $this->getUserListComponent(['search' => 'Firefly'])
            ->assertStatus(200)
            ->assertSee('Marlene')
            ->assertDontSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    function partial_search_users_by_team_name()
    {
        $joel = factory(User::class)->create([
            'first_name' => 'Joel',
            'team_id' => factory(Team::class)->create([
                'name' => 'Smuggler'
            ])->id,
        ]);
        $ellie = factory(User::class)->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);
        $marlene = factory(User::class)->create([
            'first_name' => 'Marlene',
            'team_id' => factory(Team::class)->create([
                'name' => 'Firefly'
            ])->id,
        ]);

        $this->getUserListComponent(['search' => 'Fire'])
            ->assertStatus(200)
            ->assertSee('Marlene')
            ->assertDontSee('Joel')
            ->assertDontSee('Ellie');
    }

}
