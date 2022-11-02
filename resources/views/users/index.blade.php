@extends('layout')

@section('title', $title)

@section('content')
    <h1>Usuarios</h1>

    <ul>
        @forelse($users as $user)
            <li>{{ $user }}</li>
        @empty
            <p>No hay usuarios registrados</p>
        @endforelse
    </ul>
@endsection

@section('sidebar')
    <h2>Barra lateral</h2>
@endsection