Links

<?php

/**
 * Zunächst definieren wir eine Liste der Links, die wir in einer <ul> dargestellt haben wollen.
 */
$links = [
    'https://sae.edu',
    'https://google.com',
    'https://nasa.gov'
];

var_dump($_SESSION);

?>


<ul>
    <?php
    /**
     * Nun bauen wir das <ul> aus der Linkliste.
     *
     * Wir verwenden die urlencode()-Funktion, damit Zeichen, die in einer URL Probleme machen könnten, verschlüsselt
     * werden. Später können wir sie mit urldecode() wieder zurück konvertieren.
     */
    foreach ($links as $link): ?>
        <li>
            <a href="http://localhost:8080/uebungen/3.2/helpers/redirector.php?url=<?php echo urlencode($link); ?>" target="_blank"><?php echo $link; ?></a>
            <?php
            /**
             * Wenn im redirector.php die URL in die Session gespeichert wurde, weil sie geklickt wurde, dann können
             * wir diese Information hier aus der Session auslesen und für unsere Bedingung verwenden.
             *
             * Beachte, dass wir hier auf Array Keys prüfen, weil wir die URLs in dieser Version des Recirectors von den
             * Array Values in die Keys verschoben haben.
             */
            if (isset($_SESSION['counter']) && array_key_exists($link, $_SESSION['counter'])) {
                /**
                 * Die printf()-Funktion nimmt einen Format-String entgegen, der Platzhalter beinhaltet. Alle weiteren
                 * Paramater ersetzen dann einfach nur die Platzhalter. %d ist Platzhalter für einen ganzzahligen Wert.
                 */
                printf('%dx besucht', $_SESSION['counter'][$link]); // ident mit: echo $_SESSION['counter'][$link] . ' mal besucht';
            } ?>
        </li>
    <?php endforeach; ?>
</ul>
