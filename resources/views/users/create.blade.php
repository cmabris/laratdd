@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <h1>Crear nuevo usuario</h1>

    <form action="{{ route('user.store') }}" method="post">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name">
        <br>
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('users') }}">Regresar al listado de usuarios</a>
    </p>
@endsection
