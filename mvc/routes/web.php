<?php

/**
 * use-Statements erlauben es uns Klassen mit ihrem Namespace einmal oben zu definieren. Dadurch ersparen wir uns unten
 * immer den gesamten Namespace anzugeben.
 */

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\RoomController;

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
     * Index Route
     */
    '/' => [HomeController::class, 'index'], // HomeController::class => "App\Controllers\HomeController"

    /**
     * Auth Routes
     */
    '/login' => [AuthController::class, 'loginForm'],
    '/login/do' => [AuthController::class, 'loginDo'],
    '/logout' => [AuthController::class, 'logout'],

    /**
     * Home Route
     */
    '/home' => [HomeController::class, 'home'],

    /**
     * Rooms Routes
     */
    '/rooms' => [HomeController::class, 'home'], // @todo: create separate View!
    '/rooms/{id}' => [RoomController::class, 'edit'],
    '/rooms/{id}/update' => [RoomController::class, 'update'],
    '/rooms/{id}/delete' => [RoomController::class, 'delete'],
    '/rooms/{id}/delete/confirm' => [RoomController::class, 'deleteConfirm'],
    '/rooms/create' => [RoomController::class, 'create'],
    '/rooms/store' => [RoomController::class, 'store'],

    // ...
];
