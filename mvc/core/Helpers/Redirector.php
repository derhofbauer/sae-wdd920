<?php

namespace Core\Helpers;

/**
 * Class Redirector
 *
 * Hier haben wir die Funktionalität des Redirectens in eine eigene Klasse ausgelagert, weil wir das an mehreren
 * Stellen immer wieder verwenden. Das macht mehr Sinn als eine einfache Funktion, weil wir dann unterschiedliche
 * Varianten von Redirects hier implementieren könnten.
 *
 * @package core\Helpers
 */
class Redirector
{

    /**
     * @param string|null $redirect
     */
    public static function redirect(?string $redirect = null, bool $useBaseUrl = true)
    {
        /**
         * Wurde eine Redirect-URL übergeben, leiten wir hier weiter.
         */
        if (!empty($redirect)) {
            /**
             * @todo: comment
             */
            if ($useBaseUrl === true) {
                header("Location: " . BASE_URL . "$redirect");
                exit;
            }

            header("Location: $redirect");
            exit;
        }
    }

}
