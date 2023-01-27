<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\UsersList;
use Illuminate\Http\Request;
use Livewire\Livewire;

trait GetsUserListComponent
{
    public function getUserListComponent(array $query = []): \Livewire\Testing\TestableLivewire
    {
        $request = new Request($query);

        return Livewire::test(UsersList::class, ['view' => 'index', 'request' => $request]);
    }
}