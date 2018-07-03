<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
  return [
      'user_id' => function () {
        return factory('App\User')->create()->id;
      },
      'channel_id' => function () {
        return factory('App\Channel')->create()->id;
      },
      'replies_count' => 10,
      'title' => $faker->sentence,
      'body' => $faker->paragraph
  ];
});
