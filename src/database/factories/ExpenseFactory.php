<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'description' => $faker->name,
        'amount' => rand(10, 500),
        'date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'category_id' => Category::all()->random(1)[0]->id,
        'user_id' => User::all()->random(1)[0]->id,
    ];
});
