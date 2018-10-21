<?php

use App\Models\User;

function create($class, $attributes = [], $times = null, $state)
{
    if ($state) {
        return factory($class, $times)->state($state)->create($attributes);
    }
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null, $state = null)
{
    if ($state) {
        return factory($class, $times)->state($state)->make($attributes);
    }
    return factory($class, $times)->make($attributes);
}

function create_user($role = null, $attributes = [], $times = null)
{
    if ($role) {
        return factory(User::class, $times)->states($role)->create($attributes);
    }
    return factory(User::class, $times)->create($attributes);
}
