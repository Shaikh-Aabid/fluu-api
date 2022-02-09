<?php

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'banner_1_title' => 'banner_1_title',
        'banner_1_description' => 'banner_1_description',
        'banner_2_title' => 'banner_2_title',
        'banner_2_description' => 'banner_2_description',
        'banner_3_title' => 'banner_3_title',
        'banner_3_description' => 'banner_3_description',
    ];
});
