<?php

use App\Models\User;

/**
 * @author Cho
 */
function create($class, $attributes = [], $times = null, $state = null)
{
    if ($state) {
        return factory($class, $times)->state($state)->create($attributes);
    }
    return factory($class, $times)->create($attributes);
}

/**
 * @author Cho
 */
function make($class, $attributes = [], $times = null, $state = null)
{
    if ($state) {
        return factory($class, $times)->state($state)->make($attributes);
    }
    return factory($class, $times)->make($attributes);
}

/**
 * @author Cho
 */
function create_user($role = null, $attributes = [], $times = null)
{
    if ($role) {
        return factory(User::class, $times)->states($role)->create($attributes);
    }
    return factory(User::class, $times)->create($attributes);
}

/**
 * Helper function to make fake photo
 * for user
 * @author Cho
 * @return string
 */
function uploadFakePhoto(): string
{
    $random = rand(1, 45);
    copy(base_path("../tools/people/{$random}.jpg"), storage_path("app/public/small/users/{$random}.jpg"));
    copy(base_path("../tools/people/{$random}.jpg"), storage_path("app/public/big/users/{$random}.jpg"));
    return "{$random}.jpg";
}

/**
 * Helper function to make fake image
 * for recipe
 * @author Cho
 * @return string
 */
function uploadFakeImage(): string
{
    $random = rand(1, 51);
    copy(base_path("../tools/food/{$random}.jpg"), storage_path("app/public/small/recipes/{$random}.jpg"));
    copy(base_path("../tools/food/{$random}.jpg"), storage_path("app/public/big/recipes/{$random}.jpg"));
    return "{$random}.jpg";
}
