<?php
/**
 * In diesem File befinden sich Hilfsfunktionen, die uns das Leben leichter machen sollen. Wir werden sie hauptsächlich
 * in Templates verwenden um die PHP Aufrufe mitten im HTML zu verkürzen.
 */

/**
 * Eine URL aus BASE_URL und $path generieren und returnen.
 *
 * @param string $path
 *
 * @return string
 */
function url(string $path): string {
    return BASE_URL . $path;
}

/**
 * Eine URL aus BASE_URL und $path generieren und ausgeben.
 * @param string $path
 */
function url_e(string $path) {
    echo url($path);
}

/**
 * Irgendetwas ausgeben.
 *
 * @param mixed $value
 */
function _e(mixed $value) {
    echo $value;
}
