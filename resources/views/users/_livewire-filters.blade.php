<form method="get" action="{{ route('users') }}">
    <div class="row row-filters">
        <div class="col-12">
            @foreach(['' => 'Todos', 'with_team' => 'Con equipo', 'without_team' => 'Sin equipo'] as $value => $text)
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="team" id="team_{{ $value ?: 'all' }}"
                           value="{{ $value }}" {{ $value === request('team', '') ? 'checked' : '' }}>
                    <label class="form-check-label" for="team_{{ $value ?: 'all' }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row row-filters">
        <div class="col-12">
            @foreach(trans('users.filters.states') as $value => $text)
                <div class="form-check form-check-inline">
                    <input wire:click="$emit('refreshUserList', 'state', $event.target.value)"
                            type="radio" class="form-check-input" name="state" id="state_{{ $value }}"
                           value="{{ $value }}" {{ $value === request('state') ? 'checked' : '' }}>
                    <label for="state_{{ $value }}" class="form-check-label">
                        {{ $text }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-inline form-search">
                <div class="input-group">
                    <input wire:keyup.debounce.1000ms="$emit('refreshUserList', 'search', $event.target.value)"
                            type="search" class="form-control form-control-sm"
                           placeholder="Buscar..." name="search"
                           value="{{ request('search') }}"
                    >
                </div>

                <div class="btn-group">
                    <select wire:change="$emit('refreshUserList', 'role', $event.target.value)"
                            name="role" id="role" class="select-field"
                    >
                        @foreach(trans('users.filters.roles') as $value => $text)
                            <option value="{{ $value }}"
                             {{ request('role') === $value ? 'selected' : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="btn-group drop-skills">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Habilidades
                    </button>
                    <div class="drop-menu skills-list">
                        @foreach($skillsList as $skill)
                            <div class="form-group form-check">
                                <input wire:click="$emit('refreshUserList', 'skills', $event.target.value, $event.target.checked)"
                                        name="skills[]" type="checkbox" class="form-check-input"
                                       id="skill_{{ $skill->id }}" value="{{ $skill->id }}"
                                       {{ is_array(request('skills')) && in_array($skill->id, request('skills')) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="skill_{{ $skill->id }}">
                                    {{ $skill->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-right">
            <div class="form-inline form-dates">
                <label for="from" class="form-label-sm">Fecha</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="from"
                           id="from" placeholder="Desde" value="{{ request('from') }}">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="to"
                           id="to" placeholder="Hasta" value="{{ request('to') }}">
                </div>

                <button id="btn-filter" type="submit" class="btn btn-sm btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
</form>
