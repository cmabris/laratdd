{{ csrf_field() }}

<div class="form-group">
    <label for="first_name">Nombre:</label>
    <input type="text" name="first_name" class="form-control" placeholder="Nombre"
           value="{{ old('first_name', $user->first_name) }}">
</div>

<div class="form-group">
    <label for="last_name">Apellidos:</label>
    <input type="text" name="last_name" class="form-control" placeholder="Apellidos"
           value="{{ old('last_name', $user->last_name) }}">
</div>

<div class="form-group">
    <label for="email">Correo electrónico:</label>
    <input type="email" name="email" class="form-control"
           placeholder="Correo electrónico" value="{{ old('email', $user->email) }}">
</div>

<div class="form-group">
    <label for="password">Contraseña:</label>
    <input type="password" name="password" class="form-control"
           placeholder="Escribe tu contraseña">
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

<h5>Habilidades</h5>

@foreach($skills as $skill)
    <div class="form-check form-check-inline">
        <input name="skills[]" class="form-check-input" type="checkbox"
               id="skill_{{ $skill->id }}" value="{{ $skill->id }}"
                {{ ($errors->any() ? old('skills.' . $skill->id) : $user->skills->contains($skill)) ? ' checked' : '' }}
        >
        <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
    </div>
@endforeach

<h5 class="mt-3">Rol</h5>

@foreach(trans('users.roles') as $role => $name)
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="role"
               id="role_{{ $role }}" value="{{ $role }}"
                {{ old('role', $user->role) === $role ? ' checked' : '' }}
        >
        <label class="form-check-label" for="{{ $role }}">{{ $name }}</label>
    </div>
@endforeach

<h5 class="mt-3">Estado</h5>

@foreach(trans('users.states') as $state => $label)
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio"
               name="state"
               id="state_{{ $state }}" value="{{ $state }}"
                {{ old('state', $user->state) === $state ? ' checked' : '' }}
        >
        <label class="form-check-label" for="{{ $state }}">{{ $label }}</label>
    </div>
@endforeach
