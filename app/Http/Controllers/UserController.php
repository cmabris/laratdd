<?php

namespace App\Http\Controllers;

use App\{Http\Requests\CreateUserRequest,
    Http\Requests\UpdateUserRequest,
    Profession,
    Skill,
    Sortable,
    User,
    UserFilter,
    UserProfile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(UserFilter $userFilter, Sortable $sortable)
    {
        $users = User::query()
            ->with('team','skills','profile.profession')
            ->when(request('team'), function ($query, $team) {
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
            ->filterBy($userFilter, request()->only(['state', 'role', 'search', 'skills', 'from', 'to']))
            ->orderBy('created_at', 'DESC')
            ->paginate();

        $users->appends($userFilter->valid());

        $sortable->setCurrentOrder(request('order'), request('direction'));

        return view('users.index', [
            'users' => $users,
            'view' => 'index',
            'skills' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    protected function form($view, User $user)
    {
        return view($view, [
            'user' => $user,
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function create()
    {
        return $this->form('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        return $this->form('users.edit', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('user.show', $user);
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }

    public function trash(User $user)
    {
        $user->profile()->delete();
        $user->delete();

        return redirect()->route('users');
    }

    public function trashed()
    {
        return view('users.index', [
            'users' => User::onlyTrashed()->paginate(),
            'view' => 'trash',
        ]);
    }

}
