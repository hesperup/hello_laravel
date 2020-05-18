<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Status;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Status::class, function (Faker $faker) {
    //$date_time = $faker->time;
    return [
        'content' => Str::random(10),
    ];
});
