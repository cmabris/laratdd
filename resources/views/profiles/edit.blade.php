@extends('layout')

@section('title', 'Editar perfil de usuario')

@section('content')
    @card
        @slot('header', 'Editar perfil')

        @include('shared._errors')

    <form method="post" action="{{ url('editar-perfil') }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="first_name">Nombre:</label>
            <input type="text" name="first_name" class="form-control" placeholder="Nombre"
                   value="{{ old('first_name', $user->first_name) }}">
        </div>

        <div class="form-group">
            <label for="last_name">Apellidos:</label>
            <input type="text" name="last_name" class="form-control" placeholder="Nombre"
                   value="{{ old('last_name', $user->last_name) }}">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" class="form-control"
                   placeholder="Correo electrónico" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label for="bio">Biografía:</label>
            <textarea name="bio" id="bio" class="form-control">{{ old('bio', $user->profile->bio) }}</textarea>
        </div>

        <div class="form-group">
            <label for="twitter">Twitter:</label>
            <input type="text" class="form-control" name="twitter" id="twitter"
                   value="{{ old('twitter', $user->profile->twitter) }}" placeholder="URL de tu usuario de twitter">
        </div>

        <div class="form-group">
            <label for="profession_id">Profesión:</label>
            <select name="profession_id" id="profession_id" class="form-control">
                <option value="">Selecciona una opción...</option>
                @foreach($professions as $profession)
                    <option value="{{ $profession->id }}" {{ old('profession_id', $user->profile->profession_id) == $profession->id ? ' selected' : '' }}>{{ $profession->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Actualizar perfil</button>
            <a href="{{ route('users') }}" class="btn btn-link">Regresar al listado de usuarios</a>
        </div>
    </form>
    @endcard
@endsection
