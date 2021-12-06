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
     * @param bool        $useBaseUrl
     */
    public static function redirect(?string $redirect = null, bool $useBaseUrl = true, bool $pathFromDomain = false)
    {
        /**
         * Wurde eine Redirect-URL übergeben, leiten wir hier weiter.
         */
        if (!empty($redirect)) {
            /**
             * Soll das übergeben Redirect-Ziel mit der BASE_URL geprefixt werde?
             */
            if ($useBaseUrl === true) {

                /**
                 * @todo: comment
                 */
                $host = BASE_URL;
                if ($pathFromDomain === true) {
                    $parsedUrl = parse_url(BASE_URL);
                    $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'];
                }
                header("Location: " . $host . "$redirect");
                exit;
            }

            /**
             * Wenn kein prefixing durchgeführt werden soll, leiten wir ohne Änderung weiter.
             */
            header("Location: $redirect");
            exit;
        }
    }

}
