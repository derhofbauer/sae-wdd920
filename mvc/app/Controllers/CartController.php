<?php

namespace App\Controllers;

use App\Models\Equipment;
use App\Services\CartService;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

/**
 * Cart Controller
 */
class CartController
{

    /**
     * Cart Übersicht anzeigen
     */
    public function index()
    {
        /**
         * Inhalt des Cart laden.
         */
        $equipmentsInCart = CartService::get();

        /**
         * View laden und Daten übergeben.
         */
        View::render('cart/index', [
            'equipments' => $equipmentsInCart
        ]);
    }

    /**
     * Equipment in Cart hinzufügen (+1)
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function add(int $id)
    {
        /**
         * Equipment, das hinzugefügt werden soll, laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * Equipment in Cart hinzufügen.
         */
        CartService::add($equipment);

        /**
         * Redirect.
         */
        Redirector::redirect(Session::get('referrer', '/cart'), pathFromDomain: true);
    }

    /**
     * Equipment in Cart hinzufügen (+1)
     *
     * @param int $id
     *
     * @throws \Exception
     * @todo: comment
     */
    public function addGet(int $id)
    {
        /**
         * Equipment, das hinzugefügt werden soll, laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * Equipment in Cart hinzufügen.
         */
        CartService::add($equipment);

        /**
         * Redirect.
         */
        Redirector::redirect($_GET['redirect']);
    }

    /**
     * Equipment in Cart hinzufügen (+1)
     *
     * @param int $id
     *
     * @throws \Exception
     * @todo: comment
     */
    public function addAjax(int $id)
    {
        /**
         * Equipment, das hinzugefügt werden soll, laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * Equipment in Cart hinzufügen.
         */
        CartService::add($equipment);

        /**
         * Ergebnis
         */
        echo json_encode([
            'cart' => CartService::get(),
            'count' => CartService::getCount()
        ]);
    }

    /**
     * Equipment in Cart entfernen (-1)
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function remove(int $id)
    {
        /**
         * Equipment, von dem ein Element entfernt werden soll, laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * Ein Element des Equipments entfernen.
         */
        CartService::remove($equipment);

        /**
         * Redirect.
         */
        Redirector::redirect('/cart');
    }

    /**
     * Equipment komplett aus Cart entfernen (-all)
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function removeAll(int $id)
    {
        /**
         * Equipment, das komplett aus dem Cart entfernt werden soll, laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * Aus dem Cart entfernen.
         */
        CartService::removeAll($equipment);

        /**
         * Redirect.
         */
        Redirector::redirect('/cart');
    }

}
