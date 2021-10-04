<?php

session_start();

require_once 'partials/header.php';

require_once 'partials/nav.php';

/**
 * Hier prüfen wir, ob der GET-Parameter "page" in der URL vorhanden ist.
 *
 * Die isset()-Funktion prüft dabei, ob eine Variable oder ein Array-Index/Key
 * gesetzt ist.
 */
if (isset($_GET['page'])) {
    /**
     * Nun laden wir die Inhalte entsprechend des Wertes aus dem "page" GET-
     * Parameter.
     */
    if ($_GET['page'] === 'contact') {
        require_once 'contents/contact.php';
    } elseif ($_GET['page'] === 'blog') {
        require_once 'contents/blog.php';
    } elseif ($_GET['page'] === 'links') {
        require_once 'contents/links.php';
    } else {
        /**
         * Wenn kein bekannter Wert in dem "page" GET-Paramater steht, dann
         * laden wir als "fallback" die Home Seite.
         */
        require_once 'contents/home.php';
    }
} else {
    /**
     * Ist der "page" GET-Paramater nicht gesetzt, so laden wir die Home Seite.
     */
    require_once 'contents/home.php';
}

require_once 'partials/footer.php';

?>
