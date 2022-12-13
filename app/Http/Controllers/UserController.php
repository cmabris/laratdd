<?php

namespace App\Http\Controllers;

use App\{Http\Requests\CreateUserRequest, Http\Requests\UpdateUserRequest, Profession, Skill, User, UserProfile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate();

        $title = 'Usuarios';

        return view('users.index', compact(
            'title',
            'users'
            )
        );
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
            'roles' => trans('users.roles'),
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
            'title' => 'Listado de usuarios en la papelera',
        ]);
    }

}
