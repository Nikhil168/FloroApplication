<?php

use App\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'user_name' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'first_name'=>$faker->firstname,
        'last_name'=>$faker->lastname,
        'address'=>$faker->address,
        'city'=>$faker->city,
        'house_number'=>$faker->buildingNumber,
        //'postal_code'=>$faker->postcode,
        'telephone_number'=>$faker->e164PhoneNumber,
        'status'=>$faker->randomDigit,
        'password' =>bcrypt('secret'),
    ];
});
