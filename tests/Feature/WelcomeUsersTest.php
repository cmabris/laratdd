<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /**
     * @test
     */
    function it_welcomes_users_with_nickname()
    {
        $this->get('saludo/pepe/pepote')
            ->assertStatus(200)
            ->assertSee('Bienvenido Pepe, tu apodo es pepote');
    }

    /**
     * @test
     */
    function it_welcomes_users_without_nickname()
    {
        $this->get('saludo/pepe')
            ->assertStatus(200)
            ->assertSee('Bienvenido Pepe, no tienes apodo');
    }
}
