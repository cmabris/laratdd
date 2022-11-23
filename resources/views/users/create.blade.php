@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <h1>Crear nuevo usuario</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor, corrige los siguientes errores</h6>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="post">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}">

        <br>
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">

        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" placeholder="Escribe tu contraseña">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('users') }}">Regresar al listado de usuarios</a>
    </p>
@endsection
