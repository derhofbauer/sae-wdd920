<?php

namespace App\Controllers;

use App\Models\Room;
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
        View::render('index', ['foo' => 'bar']);
    }


    /**
     * @todo: comment
     */
    public function home()
    {
        $rooms = Room::all('room_nr', 'ASC');

        View::render('home', [
            'rooms' => $rooms
        ]);
    }

}
