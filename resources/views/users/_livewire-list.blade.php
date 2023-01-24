<div>
    @includeWhen($view === 'index','users._filters')

    @if($users->isNotEmpty())
        <div class="table-responsive-lg table-striped">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col"><a href="{{ $sortable->url('first_name') }}" class="{{ $sortable->classes('first_name') }}">Nombre</a></th>
                    <th scope="col"><a href="{{ $sortable->url('email') }}" class="{{ $sortable->classes('email') }}">Correo</a></th>
                    <th scope="col"><a href="{{ $sortable->url('date') }}" class="{{ $sortable->classes('date') }}">Registrado el</a></th>
                    <th scope="col"><a href="{{ $sortable->url('login') }}" class="{{ $sortable->classes('login') }}">Último login</a></th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @each('users._row', $users, 'user')
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    @else
        <p>No hay usuarios registrados</p>
    @endif
</div>
