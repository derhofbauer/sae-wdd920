<?php

namespace Core\Helpers;

/**
 * @todo: comment
 */
class Redirector
{

    public static function redirect(?string $redirect)
    {
        if (!empty($redirect)) {
            header("Location: $redirect");
            exit;
        }
    }

}
