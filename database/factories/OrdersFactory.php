<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    $statesArray = ['pending', 'rejected', 'in-progress', 'completed', 'canceld']; // canceled
    $serviceTypesArray = ['takeaway', 'delivery'];

    return [
        "customer_id" => function() {
            return factory(App\Models\Customer::class)->create()->id;
        },
        "branch_id" => function() {
            return factory(App\Models\Branch::class)->create()->id;
        },
        "service_type" => $serviceTypesArray[rand(0,1)],
        "address_id" => function() {
            return factory(App\Models\Address::class)->create()->id;
        },
        "price" => $faker->randomFloat,
        "state" => $statesArray[rand(0,1)],
        "created_by" => function(){
            return factory(App\Models\User::class)->create()->id;
        },
        "updated_by" => function(){
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});
