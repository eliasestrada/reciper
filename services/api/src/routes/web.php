<?php

$router->get('/', function () use ($router) {
    return response(['key' => 'value']);
});