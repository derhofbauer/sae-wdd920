<?php

require_once 'partials/header.php';

require_once 'partials/nav.php';

/**
 * Die isset()-Funktion prüft, ob eine Variable oder ein Array-Index/Key gesetzt ist.
 */
if (isset($_GET['page'])) {
    if ($_GET['page'] === 'contact') {
        require_once 'contents/contact.php';
    } elseif ($_GET['page'] === 'blog') {
        require_once 'contents/blog.php';
    } else {
        require_once 'contents/home.php';
    }
} else {
    require_once 'contents/home.php';
}

require_once 'partials/footer.php';

?>
