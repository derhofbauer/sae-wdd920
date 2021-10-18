<?php

namespace App\Controllers;

use Core\View;

/**
 * Beispiel Controller
 */
class HomeController
{

    /**
     * Beispielmethode
     */
    public function index()
    {
        View::render('home', ['foo' => 'bar']);
    }

}
