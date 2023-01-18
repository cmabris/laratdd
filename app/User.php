<?php

namespace App;

use App\Filters\UserFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'active' => 'bool'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }

    public function newQueryFilter()
    {
        return new UserFilter;
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class)->withDefault();
    }

    public function lastLogin()
    {
        return $this->hasOne(Login::class)
            ->orderByDesc('created_at');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStateAttribute()
    {
        if ($this->active != null) {
            return $this->active ? 'active' : 'inactive';
        }
    }

    public function setStateAttribute($value)
    {
        $this->attributes['active'] = $value == 'active';
    }
}
