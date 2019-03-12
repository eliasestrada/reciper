<?php

use App\Models\User;

/**
 * @param mixed $class
 * @param array $attributes
 * @param null|int $times
 * @param null|string $state
 * @return mixed
 */
function create($class, array $attributes = [], ?int $times = null, ?string $state = null)
{
    return $state
        ? factory($class, $times)->state($state)->create($attributes)
        : factory($class, $times)->create($attributes);
}

/**
 * @param mixed $class
 * @param array $attributes
 * @param int|null $times
 * @param string|null $state
 * @return mixed
 */
function make($class, array $attributes = [], ?int $times = null, ?string $state = null)
{
    return $state
        ? factory($class, $times)->state($state)->make($attributes)
        : factory($class, $times)->make($attributes);
}

/**
 * @param string|null $role
 * @param array $attributes
 * @param int|null $times
 * @return mixed
 */
function create_user(?string $role = null, array $attributes = [], ?int $times = null)
{
    return $role
        ? factory(User::class, $times)->states($role)->create($attributes)
        : factory(User::class, $times)->create($attributes);
}

/**
 * Helper function to make fake image
 * for recipe
 * 
 * @return string
 */
function uploadFakeImage(): string
{
    $random = mt_rand(1, 51);
    copy(base_path("../tools/food/{$random}.jpg"), storage_path("app/public/small/recipes/{$random}.jpg"));
    copy(base_path("../tools/food/{$random}.jpg"), storage_path("app/public/big/recipes/{$random}.jpg"));
    return "{$random}.jpg";
}
