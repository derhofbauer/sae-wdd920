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
            <a href="http://localhost:8080/uebungen/3.1/helpers/redirector.php?url=<?php echo urlencode($link); ?>" target="_blank"><?php echo $link; ?></a>
            <?php
            /**
             * Wenn im redirector.php die URL in die Session gespeichert wurde, weil sie geklickt wurde, dann können
             * wir diese Information hier aus der Session auslesen und für unsere Bedingung verwenden.
             */
            if (isset($_SESSION['urls']) && in_array($link, $_SESSION['urls'])) {
                echo "besucht";
            } ?>
        </li>
    <?php endforeach; ?>
</ul>
