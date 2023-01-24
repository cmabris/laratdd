<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use Livewire\Component;

class UsersList extends Component
{
    protected $view;

    public function mount($view)
    {
        $this->view = $view;
    }

    protected function getUsers(Sortable $sortable)
    {
        $users = User::query()
            ->with('team','skills','profile.profession')
            ->withLastLogin()
            ->onlyTrashedIf(request()->routeIs('users.trashed'))
            ->when(request('team'), function ($query, $team) {
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
            ->applyFilters()
            ->orderBy('created_at', 'desc')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        $sortable = new Sortable(request()->url());

        $this->view = 'index';

        return view('users._livewire-list', [
            'users' => $this->getUsers($sortable),
            'view' => $this->view,
            'skills' => Skill::getList(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }
}
