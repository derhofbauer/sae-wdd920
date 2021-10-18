<?php

/**
 * use-Statements erlauben es uns Klassen mit ihrem Namespace einmal oben zu definieren. Dadurch ersparen wir uns unten
 * immer den gesamten Namespace anzugeben.
 */
use App\Controllers\HomeController;
use App\Controllers\ChannelController;

/**
 * Die Dateien im /routes Ordner beinhalten ein Mapping von einer URL auf eine eindeutige Controller & Action
 * kombination. Als Konvention definieren wir, dass URL-Parameter mit {xyz} definiert werden müssen, damit das Routing
 * korrekt funktioniert.
 *
 * + /blog/{slug} --> BlogController->show($slug)
 * + /shop/{id} --> ProductController->show($id)
 */

return [
    /**
     * Home Route
     */
    '/' => [HomeController::class, 'index'], // HomeController::class => "App\Controllers\HomeController"

    /**
     * Channel Routes
     */
    '/channels' => [ChannelController::class, 'index'],
    '/channels/{id}' => [ChannelController::class, 'show'],

    // ...
];
