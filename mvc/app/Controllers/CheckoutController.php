<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Services\CartService;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Session;
use Core\View;

/**
 * @todo: comment
 */
class CheckoutController
{

    public function __construct()
    {
        AuthMiddleware::isLoggedInOrFail();
    }

    public function summary()
    {
        $cartContent = CartService::get();
        $user = User::getLoggedIn();

        View::render('checkout/summary', [
            'cartContent' => $cartContent,
            'user' => $user
        ]);
    }

    public function finish()
    {
        /**
         * + Booking Einträge anlegen
         * + Units reduzieren
         */
        $cartContent = CartService::get();
        $user = User::getLoggedIn();

        foreach ($cartContent as $itemFromCart) {
            for ($i = 1; $i <= $itemFromCart->count; $i++) {
                $booking = new Booking();
                $booking->fill([
                    'user_id' => $user->id,
                    'foreign_table' => $itemFromCart::class,
                    'foreign_id' => $itemFromCart->id
                ]);
                if (!$booking->save()) {
                    Session::set('errors', ['Bookings konnten nicht gespeichert werden.']);
                    Redirector::redirect('/checkout/summary');
                }
            }

            if (property_exists($itemFromCart, 'units')) {
                $itemFromCart->units = $itemFromCart->units - $itemFromCart->count;
                $itemFromCart->save();
            }
        }

        CartService::destroy();
        Session::set('success', ['Equipment erfolgreich gebucht!']);
        Redirector::redirect('/home');
    }

}
