@extends('layout')

@section('title', $title)

@section('content')
    <h1>Usuarios</h1>
    <p>
        <a href="{{ route('user.create') }}">Nuevo usuario</a>
    </p>
    <ul>
        @forelse($users as $user)
            <li>
                {{ $user->name }} ({{ $user->email }})
                <a href="{{ route('user.show', $user) }}">Ver detalles</a>
                <a href="{{ route('users.edit', $user) }}">Editar</a>
                <form action="{{ route('user.destroy', $user) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @empty
            <p>No hay usuarios registrados</p>
        @endforelse
    </ul>
@endsection