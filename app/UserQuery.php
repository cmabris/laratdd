<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends Builder
{
    use FiltersQueries;

    public function filterRules()
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
        ];
    }
    public function findByEmail($email)
    {
        return static::whereEmail($email)->first();
    }

    public function filterBySearch($search)
    {
        return $this->where(function ($query) use ($search) {
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        });
    }

    public function filterByState($state)
    {
        return $this->where('active', $state === 'active');
    }
}