<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Candidate;
use App\User;
use Faker\Generator as Faker;

$factory->define(Candidate::class, function (Faker $faker) {
    $owners = User::all();
    $manager = $owners->where('role', 'manager')->first();

    foreach ($owners as $owner) {
        if ($owner->role == 'agent') {
            $owner_id = $owner->id;
        }
    }

    return [
        'name' => $faker->name(),
        'source' => $faker->name(),
        'user_id' => $owner_id,
        'created_by' => $manager->id,
    ];
});
