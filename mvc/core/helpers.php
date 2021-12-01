<?php

/**
 * @param string $path
 *
 * @return string
 * @todo: comment
 */
function url(string $path): string {
    return BASE_URL . $path;
}

function url_e(string $path) {
    echo url($path);
}

function _e(mixed $value) {
    echo $value;
}
