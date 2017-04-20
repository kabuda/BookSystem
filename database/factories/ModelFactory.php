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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {
    $book_price = random_int(0, 100);
    $book_amount = random_int(0, 10);
    $book_total_price = $book_price * $book_amount;
    return [
        'book_name'        => $faker->name,
        'book_price'       => $book_price,
        'book_author'      => $faker->name,
        'book_count'      => $book_amount,
        'book_isbn'        => str_random(13),
        'book_total_price' => $book_total_price,
        'book_invNum'     => str_random(15),
        'status'=>0,
        'user_id'=>$faker->randomElement(App\User::lists('id')->toArray()),
    ];
});

$factory->define(App\BookList::class, function (Faker\Generator $faker) {
    return [
        'serialNumber'=>App\BookList::makeSerialNumber(),
        'book_id'=>$faker->randomElement(App\Book::lists('id')->toArray()),
        'user_id'=>$faker->randomElement(App\User::lists('id')->toArray()),
        'status'=>0
    ];
});
