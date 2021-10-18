<?php

/**
 * @todo: comment
 */
use App\Controllers\HomeController;
use App\Controllers\ChannelController;

/**
 * @todo: comment
 */
return [
    '/' => [HomeController::class, 'index'], // HomeController::class => "App\Controllers\HomeController"

    '/channels' => [ChannelController::class, 'index'],
    '/channels/{id}' => [ChannelController::class, 'show'],

    // ...
];
