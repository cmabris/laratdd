<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_completely_deletes_a_user()
    {
        $user = factory(User::class)->create();

        $this->delete('usuarios/' . $user->id)
            ->assertRedirect('usuarios');

        $this->assertDatabaseEmpty('users');
    }

    function it_sends_a_user_to_the_trash()
    {
        $user = factory(User::class)->create();

        $this->patch('usuarios/' . $user->id . '/papelera')
            ->assertRedirect('usuarios');

        //Opción 1
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);

        //Opción 2
        $user->refresh();
        $this->assertTrue($user->trashed());
    }
}
