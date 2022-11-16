@extends('layout')

@section('title', "Usuario #{$user->id}")

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    <p>Mostrando los detalles del usuario {{ $user->name }}</p>
    <p>Correo electrónico: {{ $user->email }}</p>
    <p>
        <a href="{{ route('users') }}">Regresar al listado de usuarios</a>
    </p>
@endsection
