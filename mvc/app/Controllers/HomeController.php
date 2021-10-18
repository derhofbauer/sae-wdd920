<?php

namespace App\Controllers;

use Core\View;

/**
 * @todo: comment
 */
class HomeController
{

    public function index () {
        View::render('home', ['foo' => 'bar']);
    }

}
