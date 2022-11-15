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

    public function show($id)
    {
        return view('users.show', compact('id'));
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }
}
