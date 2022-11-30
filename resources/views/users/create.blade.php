@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="card">
        <div class="card-header h4">
            Crear nuevo usuario
        </div>
    </div>

    @include('shared._errors')

    <form action="{{ route('user.store') }}" method="post">

        @include('users._fields')

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Crear usuario</button>
            <a href="{{ route('users') }}" class="btn btn-link">Regresar al listado de usuarios</a>
        </div>
    </form>
@endsection
