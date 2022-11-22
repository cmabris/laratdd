<?php

namespace App\Http\Controllers;

use App\User;
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
        return view('users.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('users');
    }
}
