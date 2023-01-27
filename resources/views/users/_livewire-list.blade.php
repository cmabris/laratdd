<div id="users-table">
    @includeWhen($view === 'index','users._filters')

    <p><a href="#" wire:click="$refresh()" class="btn btn-info">Recargar componente</a></p>

    @if($users->isNotEmpty())
        <div class="table-responsive-lg table-striped">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    @foreach(['first_name' => 'Nombre', 'email' => 'Correo', 'date' => 'Registrado el', 'login' => 'Último login'] as $column => $title)
                        <th scope="col">
                            <a wire:click.prevent="changeOrder('{{ $sortable->order($column) }}')" href="{{ $sortable->url($column) }}" class="{{ $sortable->classes($column) }}">
                                {{ $title }} <i class="icon-sort" />
                            </a>
                        </th>
                    @endforeach
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
