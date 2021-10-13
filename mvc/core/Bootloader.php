<?php

namespace Core;

/**
 * Class Bootloader
 *
 * @package Core
 */
class Bootloader
{

    public function __construct()
    {
        // Routing
        // Controller laden
        // Action aufrufen
    }

    /**
     * Je nach Umgebung, welche Umgebung (dev/prod) gerade konfiguriert ist, schalten wir das error reporting ein oder
     * aus.
     */
    public static function setErrorDisplay ()
    {
        /**
         * Config aus dem app.php Config File auslesen
         */
        $environment = Config::get('app.environment', 'prod');

        /**
         * Wenn grade die dev Environment konfiguriert ist ...
         */
        if ($environment === 'dev') {
            /**
             * ... zeigen wir alle Fehler an.
             *
             * Hier werden zwei PHP Einstellungen überschrieben, die in der php.ini Datei konfiguriert sind.
             */
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            /**
             * E_ALL ist eine von PHP mitgelieferte Konstante zur Konfiguration. Hier wird definiert, dass wir ALLE
             * Fehler angezeigt bekommen möchten.
             */
            error_reporting(E_ALL);
        }
    }

}
