<?php

namespace Tests\Livewire;

use Tests\TestCase;

class UserListTest extends TestCase
{
    use GetsUserListComponent;

    /** @test */
    function listens_to_refresh_users_list()
    {
        $this->getUserListComponent()
            ->assertNotSet('search', 'Pepe')
            ->assertSet('search', null)
            ->emit('refreshUserList', 'search', 'Pepe')
            ->assertSet('search', 'Pepe');
    }

    /** @test */
    function adds_an_aditional_skill()
    {
        $this->getUserListComponent(['skills' => [2]])
            ->assertSet('skills', [2 => 2])
            ->emit('refreshUserList', 'skills', 3)
            ->assertSet('skills', [2 => 2, 3 => 3]);
    }

    /** @test */
    function removes_a_skill()
    {
        $this->getUserListComponent(['skills' => [3,4]])
            ->emit('refreshUserList', 'skills', 3, false)
            ->assertSet('skills', [4 => 4]);
    }

    /** @test */
    function changing_the_order_resets_the_page()
    {
        $this->getUserListComponent(['page' => 5])
            ->assertSet('page', 5)
            ->assertSet('order', null)
            ->call('changeOrder', 'first_name')
            ->assertSet('order', 'first_name')
            ->assertSet('page', 1);
    }
}