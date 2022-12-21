<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return static::whereEmail($email)->first();
    }
}