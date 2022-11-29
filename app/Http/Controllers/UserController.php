<?php

namespace App\Http\Controllers;

use App\{Http\Requests\CreateUserRequest, Profession, Skill, User, UserProfile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        //$users = DB::table('users')->get();

        $users = User::all();

        $title = 'Listado de usuarios';

        /*if (request()->has('empty')) {
            $users = [];
        } else {
            $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
        }*/

        return view('users.index', compact(
            'title',
            'users'
            )
        );

        /*return view('users.index')
            ->with('users', User::all())
            ->with('title', 'Listado de usuarios');*/
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create', [
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'roles' => trans('users.roles'),
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => '',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }

}
