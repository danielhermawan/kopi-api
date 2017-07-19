<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' =>$faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'phone_number' => $faker->phoneNumber,
        'gender' => $faker->randomElement(["male", "female"]),
        'address' => $faker->address,
        'is_active' => $faker->numberBetween(0, 1),
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    $categories = App\Models\ProductCategory::pluck("id");

    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween($min = 10000, $max = 100000),
        'currency' => 'IDR',
        'image_url' => 'http://kopigo.folto.co/uploads/images/coffee.png',
        'category_id' => $faker->randomElement($categories->toArray()),
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {

    return [
       'user_id' => App\Models\User::first()->id
    ];
});