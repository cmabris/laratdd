<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $view;
    public $originalUrl;

    public $search;
    public $state;
    public $role;
    public $skills = [];
    public $from;
    public $to;
    public $order;

    protected $queryString = [
        'search' => ['except' => ''],
        'state' => ['except' => 'all'],
        'role' => ['except' => 'all'],
        'skills' => [],
        'from' => ['except' => ''],
        'to' => ['except' => ''],
        'order' => ['except' => ''],
    ];

    public function mount($view, Request $request)
    {
        $this->view = $view;
        $this->originalUrl = $request->url();
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
            ->applyFilters([
                'search' => $this->search,
                'state' => $this->state,
                'role' => $this->role,
                'skills' => $this->skills,
                'from' => $this->from,
                'to' => $this->to,
                'order' => $this->order,
            ])
            ->orderBy('created_at', 'desc')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function changeOrder($order)
    {
        $this->order = $order;
        $this->resetPage();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sortable = new Sortable($this->originalUrl);

        $this->view = 'index';

        return view('users._livewire-list', [
            'users' => $this->getUsers($sortable),
            'view' => $this->view,
            'skillsList' => Skill::getList(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }
}
