<?php

namespace Core\Middlewares;

use App\Models\User;
use Core\View;

/**
 * @todo: comment!
 */
class AuthMiddleware
{

    public static function isAdmin(): ?bool
    {
        return User::getLoggedIn()?->is_admin;
    }

    public static function isAdminOrFail()
    {
        $isAdmin = self::isAdmin();

        if ($isAdmin !== true) {
            throw new \Exception('Forbidden', 403);
        }
    }

    public static function isLoggedInOrFail()
    {
        $isLoggedIn = User::isLoggedIn();

        if ($isLoggedIn !== true) {
            throw new \Exception('Forbidden', 403);
        }
    }

}
