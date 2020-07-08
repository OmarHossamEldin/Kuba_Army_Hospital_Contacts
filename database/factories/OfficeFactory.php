<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Office;
use Faker\Generator as Faker;

$factory->define(Office::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'لا يوجد',
        'department_id' => 1,
        'user_id' => 1
    ];
});
