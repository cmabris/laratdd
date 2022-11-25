@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="card">
        <div class="card-header h4">
            Crear nuevo usuario
        </div>
    </div>

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

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" class="form-control" placeholder="Nombre"
                   value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" class="form-control"
                   placeholder="Correo electrónico" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control"
                   placeholder="Escribe tu contraseña">
        </div>

        <div class="form-group">
            <label for="bio">Biografía:</label>
            <textarea name="bio" id="bio" class="form-control">{{ old('bio') }}</textarea>
        </div>

        <div class="form-group">
            <label for="twitter">Twitter:</label>
            <input type="text" class="form-control" name="twitter" id="twitter"
                value="{{ old('twitter') }}" placeholder="URL de tu usuario de twitter">
        </div>

        <button type="submit" class="btn btn-primary">Crear usuario</button>
        <a href="{{ route('users') }}" class="btn btn-link">Regresar al listado de usuarios</a>
    </form>
@endsection
