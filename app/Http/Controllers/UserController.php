<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Listado de usuarios';

        if (request()->has('empty')) {
            $users = [];
        } else {
            $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
        }

        return view('users.index', compact(
            'title',
            'users'
            )
        );
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
