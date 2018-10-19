<?php

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}

function create_user($role = null, $attributes = [], $times = null)
{
    if ($role) {
        return factory(\App\Models\User::class, $times)->states($role)->create($attributes);
    }
    return factory(\App\Models\User::class, $times)->create($attributes);
}

function make_user($role = null, $attributes = [], $times = null)
{
    if ($role) {
        return factory(\App\Models\User::class, $times)->states($role)->make($attributes);
    }
    return factory(\App\Models\User::class, $times)->make($attributes);
}
