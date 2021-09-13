<?php

session_start();

/**
 * [ ] Redirect URL aus GET-Parameter auslesen
 * [ ] Click tracken
 * [ ] zu Redirect URL weiterleiten
 * @todo: comment
 */

$url = urldecode($_GET['url']);

if (!isset($_SESSION['urls'])) {
    $_SESSION['urls'] = [];
}

if (!in_array($url, $_SESSION['urls'])) {
    $_SESSION['urls'][] = $url;
}

header("Location: $url");
