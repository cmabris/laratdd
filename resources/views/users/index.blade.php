@extends('livewire-layout')

@section('title', trans("users.title.{$view}"))

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Usuarios</h1>
        <p>
            @if($view === 'index')
                <a href="{{ route('users.trashed') }}" class="btn btn-success">Ver Papelera</a>
                <a href="{{ route('user.create') }}" class="btn btn-primary">Nuevo usuario</a>
            @else
                <a href="{{ route('users') }}" class="btn btn-primary">Usuarios</a>
            @endif
        </p>
    </div>

    @livewire('users-list', compact([
    'users',
    'view',
    'skills',
    'checkedSkills',
    'sortable',
]))

@endsection

@section('sidebar')
    @parent
@endsection
