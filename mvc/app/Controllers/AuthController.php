<?php

namespace App\Controllers;

use Core\Helpers\Redirector;
use Core\Session;
use Core\View;
use App\Models\User;

/**
 * @todo: comment
 */
class AuthController
{

    public function loginForm()
    {
        if (User::isLoggedIn()) {
            Redirector::redirect(BASE_URL . '/home');
        }

        View::render('auth/login');
    }

    public function loginDo()
    {
        /**
         * [x] Daten "validieren"
         * [x] User anhand Username/Password aus DB laden
         * [ ] Password prüfen
         * [ ] Fehler oder Login!
         */
        if (
            isset($_POST['username-or-email'], $_POST['password'])
            && !empty($_POST['username-or-email'])
            && !empty($_POST['password'])
        ) {
            $user = User::findByEmailOrUsername($_POST['username-or-email']);

            $errors = [];

            if (empty($user) || !$user->checkPassword($_POST['password'])) {
                $errors[] = 'Username/E-Mail oder Passwort sind falsch.';
            } else {
                $user->login(BASE_URL . '/home');
            }

            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/login');
        }
    }

    public function logout()
    {
        User::logout(BASE_URL);
    }

}
