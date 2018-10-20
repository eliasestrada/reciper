<?php

// Mockery
$mock = \Mockery::mock('\App\Models\Recipe');
$mock->shouldReceive('ingredientsWithListItems')->once()->andReturn(['test']);
$this->assertEquals(['test'], $mock->ingredientsWithListItems());

// Set Relation
$user = make(User::class, ['id' => $id = rand(2, 10000)]);
$ban = Ban::make([
    'user_id' => $id,
    'days' => 1,
    'message' => 'some message',
]);
$ban->setRelation('user', $user);
$this->assertEquals($user->id, $ban->user->id);
