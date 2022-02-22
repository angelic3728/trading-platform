<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Document::class, function (Faker $faker) {
    return [
        'type' => 'txt',
        'title' => $faker->sentence(3),
        'file' => 'documents/example.txt',
        'description' => $faker->paragraph,
        'provided_by' => 1,
    ];
});
