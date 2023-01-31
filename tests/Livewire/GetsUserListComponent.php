<?php

namespace Tests\Livewire;

use App\Http\Livewire\UserList;
use Illuminate\Http\Request;
use Livewire\Livewire;

trait GetsUserListComponent
{
    public function getUserListComponent(array $query = []): \Livewire\Testing\TestableLivewire
    {
        $request = new Request($query);

        return Livewire::test(UserList::class, ['view' => 'index', 'request' => $request]);
    }
}