<?php

namespace Tests\Feature\Admin;

use App\Skill;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function filter_users_by_state_active()
    {
        $activeUser = factory(User::class)
            ->create(['first_name' => 'John Doe']);
        $inactiveUser = factory(User::class)
            ->state('inactive')
            ->create(['first_name' => 'Jane Doe']);

        $response = $this->get('usuarios?state=active');

        $response->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $activeUser = factory(User::class)
            ->create(['first_name' => 'John Doe']);
        $inactiveUser = factory(User::class)
            ->state('inactive')
            ->create(['first_name' => 'Jane Doe']);

        $response = $this->get('usuarios?state=inactive');

        $response->assertSee('Jane Doe')
            ->assertDontSee('John Doe');
    }

    /** @test */
    function filter_users_by_role_admin()
    {
        $admin = factory(User::class)->create(['first_name' => 'John Doe', 'role' => 'admin']);
        $user = factory(User::class)->create(['first_name' => 'Jane Doe', 'role' => 'user']);

        $response = $this->get('usuarios?role=admin');

        $response->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function filter_users_by_role_user()
    {
        $admin = factory(User::class)->create(['first_name' => 'John Doe', 'role' => 'admin']);
        $user = factory(User::class)->create(['first_name' => 'Jane Doe', 'role' => 'user']);

        $response = $this->get('usuarios?role=user');

        $response->assertSee('Jane Doe')
            ->assertDontSee('John Doe');
    }

    /** @test */
    function filter_users_by_skill()
    {
        $php = factory(Skill::class)->create(['name' => 'PHP']);
        $css = factory(Skill::class)->create(['name' => 'CSS']);

        $backendDev = factory(User::class)->create(['first_name' => 'John Doe']);
        $backendDev->skills()->attach($php);

        $frontendDev = factory(User::class)->create(['first_name' => 'Jane Doe']);
        $frontendDev->skills()->attach($css);

        $fullStackDev = factory(User::class)->create(['first_name' => 'Joane Doe']);
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $response = $this->get("usuarios?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertSee('Joane Doe')
            ->assertDontSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function filter_users_created_from_date()
    {
        $newestUser = factory(User::class)->create([
            'first_name' => 'The Newest User',
            'created_at' => '2022-10-02 12:00:00'
        ]);
        $oldestUser = factory(User::class)->create([
            'first_name' => 'The Oldest User',
            'created_at' => '2022-09-29 12:00:00'
        ]);
        $newUser = factory(User::class)->create([
            'first_name' => 'The New User',
            'created_at' => '2022-10-01 00:00:00'
        ]);
        $oldUser = factory(User::class)->create([
            'first_name' => 'The Old User',
            'created_at' => '2022-09-30 23:59:59'
        ]);

        $response = $this->get('usuarios?from=01/10/2022');

        $response->assertOk();

        $response->assertSee('The Newest User')
            ->assertSee('The New User')
            ->assertDontSee('The Old User')
            ->assertDontSee('The Oldest User');
    }

    /** @test */
    function filter_users_created_to_date()
    {
        $newestUser = factory(User::class)->create([
            'first_name' => 'The Newest User',
            'created_at' => '2022-10-02 12:00:00'
        ]);
        $oldestUser = factory(User::class)->create([
            'first_name' => 'The Oldest User',
            'created_at' => '2022-09-29 12:00:00'
        ]);
        $newUser = factory(User::class)->create([
            'first_name' => 'The New User',
            'created_at' => '2022-10-01 00:00:00'
        ]);
        $oldUser = factory(User::class)->create([
            'first_name' => 'The Old User',
            'created_at' => '2022-09-30 23:59:59'
        ]);

        $response = $this->get('usuarios?to=30/09/2022');

        $response->assertOk();

        $response->assertSee('The Oldest User')
            ->assertSee('The Old User')
            ->assertDontSee('The New User')
            ->assertDontSee('The Newest User');
    }
}
