@extends('layout')

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

    @includeWhen($view === 'index','users._filters')

    @if($users->isNotEmpty())
        <div class="table-responsive-lg table-striped">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col" class="sort-desc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col">Rol <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col">Fechas <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @each('users._row', $users, 'user')
                </tbody>
            </table>
        {{ $users->links() }}
    @else
        <p>No hay usuarios registrados</p>
    @endif
@endsection

@section('sidebar')
    @parent
@endsection
