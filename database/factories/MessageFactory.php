<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $user = rand(1,2);
    if($user == 1) $user = 2;
    else $user2 = 1;
    return [
        'message' => $faker->paragraph,
        'user_receive' => $user,
        'user_send' => $user2,
    ];
});
