<?php

namespace App\Controllers;

use App\Models\Equipment;
use App\Services\CartService;
use Core\Helpers\Redirector;
use Core\View;

/**
 * @todo: comment
 */
class CartController
{

    public function index()
    {
        $equipmentsInCart = CartService::get();

        View::render('cart/index', [
            'equipments' => $equipmentsInCart
        ]);
    }

    public function add(int $id)
    {
        $equipment = Equipment::findOrFail($id);

        CartService::add($equipment);

        Redirector::redirect('/cart');
    }

    public function remove(int $id)
    {
        $equipment = Equipment::findOrFail($id);

        CartService::remove($equipment);

        Redirector::redirect('/cart');
    }

    public function removeAll(int $id)
    {
        $equipment = Equipment::findOrFail($id);

        CartService::removeAll($equipment);

        Redirector::redirect('/cart');
    }

}
