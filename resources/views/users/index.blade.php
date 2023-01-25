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
    'view',
    ]))

@endsection

@section('sidebar')
    @parent
@endsection

@push('scripts')
    <script>
        function loadCalendars() {
            ['from', 'to'].forEach(function (field) {
                $('#'+field).datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'dd/mm/yyyy'
                }).on('change', function () {
                    var usersTableId = $('#users-table').attr('wire:id');

                    var usersTable = window.livewire.find(usersTableId);

                    if (usersTable.get(field) != $(this).val()) {
                        usersTable.set(field, $(this).val());
                    }
                });
            });
        }

        loadCalendars();
        $('#btn-filter').hide();

        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', (message,component) =>  {
                loadCalendars();
            })
        })
    </script>
@endpush