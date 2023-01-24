<?php

namespace App\Http\Controllers;

use App\{Http\Requests\CreateUserRequest, Http\Requests\UpdateUserRequest, Profession, Skill, Sortable, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('users.index', [
            'view' => $request->routeIs('users.trashed') ? 'trash' : 'index',
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
        $user->delete();

        return redirect()->route('users');
    }

    /*public function trashed(Sortable $sortable)
    {
        $users = User::onlyTrashed()
            ->when(request('order'), function ($q) {
                $q->orderBy(request('order'), request('direction','asc'));
            }, function ($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->paginate();

        $sortable->setCurrentOrder(request('order'), request('direction'));

        return view('users.index', [
            'users' => $users,
            'view' => 'trash',
            'sortable' => $sortable,
        ]);
    }*/

}
