<?php

namespace Core\Models;

use App\Models\User;
use Core\Database;
use Core\Session;
use Core\Helpers\Redirector;

/**
 * @todo: comment
 */
abstract class AbstractUser extends AbstractModel
{

    const LOGGED_IN_STATUS = 'is_logged_in';
    const LOGGED_IN_USER_ID = 'logged_in_user_id';

    public static function findByEmailOrUsername(string $emailOrUsername): ?object
    {
        $emailOrUsername = trim($emailOrUsername);

        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        $result = $database->query("SELECT * FROM $tablename WHERE email = ? OR username = ? LIMIT 1", [
            's:email' => $emailOrUsername,
            's:username' => $emailOrUsername
        ]);

        $result = self::handleUniqueResult($result);

        return $result;
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function login(?string $redirect): bool
    {
        Session::set(self::LOGGED_IN_STATUS, true);
        Session::set(self::LOGGED_IN_USER_ID, $this->id);

        Redirector::redirect($redirect);

        return true;
    }

    public static function logout(?string $redirect): bool
    {
        Session::set(self::LOGGED_IN_STATUS, false);
        Session::forget(self::LOGGED_IN_USER_ID);

        Redirector::redirect($redirect);

        return true;
    }

    public static function isLoggedIn(): bool
    {
        if (
            Session::get(self::LOGGED_IN_STATUS, false) === true
            && Session::get(self::LOGGED_IN_USER_ID, null) !== null
        ) {
            return true;
        }

        return false;
    }

    public static function getLoggedIn(): ?User
    {
        if (self::isLoggedIn()) {
            $userId = Session::get(self::LOGGED_IN_USER_ID, null);

            if ($userId !== null) {
                return User::findOrFail($userId);
            }
        }

        return null;
    }

}
