<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sponser;
use App\Event;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Sponser::class, function (Faker $faker) {
    return [
    	'user_id' => function(){
    		$us = User::role('manager')->inRandomOrder()->pluck('id')->toArray();
    		return Arr::random($us);
    	},
    	'event_id' => function(){
    		$ev = Event::inRandomOrder()->pluck('id')->toArray();
    		return Arr::random($ev);
    	},
        'full_name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'company_name' => $faker->company
    ];
});
