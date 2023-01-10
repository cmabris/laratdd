<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return static::whereEmail($email)->first();
    }
}