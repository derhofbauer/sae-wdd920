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
     * @param bool        $pathFromDomain
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
                 * Soll der Pfad relativ zur Domain und nicht relativ zur BASE_URL definiert werden ...
                 */
                $host = BASE_URL;
                if ($pathFromDomain === true) {
                    /**
                     * ... so holen wir nur die Domain aus der BASE_URL.
                     */
                    $host = self::prepareHostFromBaseUrl();
                }
                header("Location: {$host}{$redirect}");
                exit;
            }

            /**
             * Wenn kein prefixing durchgeführt werden soll, leiten wir ohne Änderung weiter.
             */
            header("Location: $redirect");
            exit;
        }
    }

    /**
     * Protokoll, Host und Port aus der BASE_URL extrahieren.
     *
     * @return string
     */
    private static function prepareHostFromBaseUrl(): string
    {
        $parsedUrl = parse_url(BASE_URL);
        $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'];

        return $host;
    }

}
