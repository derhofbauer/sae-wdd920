<?php

namespace App\Controllers;

use Core\Helpers\Redirector;
use Core\Session;
use Core\View;
use App\Models\User;

/**
 * Class AuthController
 *
 * @package App\Controllers
 */
class AuthController
{

    /**
     * Loin Formular anzeigen
     */
    public function loginForm()
    {
        /**
         * Wenn bereits ein*e User*in eingeloggt ist, zeigen wir das Login Formular nicht an, sondern leiten auf die
         * Startseite weiter.
         */
        if (User::isLoggedIn()) {
            Redirector::redirect('/home');
        }

        /**
         * Andernfalls laden wir das Login Formular.
         */
        View::render('auth/login');
    }

    /**
     * Daten aus Login Formular entgegennehmen und verarbeiten.
     */
    public function loginDo()
    {
        /**
         * 1) Username & Passwort ins Login Formular eingeben
         * 2) Remember Me Checkbox anhakerln (optional)
         * 3) Formular absenden
         * ---
         * 4) Gibts den/die User*in schon? ja: weiter, nein: Fehlermeldung
         * 5) Passwort aus DB abrufen (Salted Hashes)
         * 6) Passwort aus Eingabe und DB ident? ja: weiter, nein: Fehlermeldung
         * 7) "Remember Me" angehakerlt? ja: $exp=7, nein: $exp=0 (für die aktuelle Browser Session, bis der Tab
         * geschlossen wird)
         * 8) Session schreiben: logged_in=>true
         * 9) Redirect zu bspw. Dashboard/Home Seite/whatever
         */

        /**
         * User anhand einer Email-Adresse oder eines Usernames aus der Datenbank laden.
         * Diese Funktionalität kommt aus der erweiterten Klasse AbstractUser.
         */
        $user = User::findByEmailOrUsername($_POST['username-or-email']);

        /**
         * Fehler-Array vorbereiten
         */
        $errors = [];

        /**
         * Wurde ein*e User*in in der Datenbank gefunden und stimmt das eingegebene Passwort mit dem Passwort Hash
         * des/der User*in überein?
         *
         * Hier ist wichtig zu bedenken, dass wir nicht zwei unterschiedliche Fehlermeldungen ausgeben, damit wir nicht
         * einem Angreifer verraten, dass der Username richtig ist und nur das Passwort noch nicht. Dadurch wäre es
         * nämlich erheblich einfacher, das Passwort zu brute-forcen.
         */
        if (empty($user) || !$user->checkPassword($_POST['password'])) {
            /**
             * Wenn nein: Fehler!
             */
            $errors[] = 'Username/E-Mail oder Passwort sind falsch.';
        } else {
            /**
             * Wenn ja: weiter.
             */
            $user->login('/home');
        }

        /**
         * Fehler in die Session schreiben und zum Login zurückleiten. In die Session speichern wir deshalb, weil wir
         * im Login Formular nicht mehr auf die Variable $errors zugreifen können und daher eine Möglichkeit brauchen
         * über einen Request hinweg Daten zu speichern. Im Login Form laden wir die Fehler aus der Session, zeigen sie
         * an und löschen sie in der Session wieder.
         */
        Session::set('errors', $errors);
        Redirector::redirect('/login');
    }

    /**
     * Logout und redirect auf die Startseite durchführen.
     */
    public function logout()
    {
        User::logout('/');
    }

}
