<?php

namespace App\Models;

use Core\Models\AbstractUser;
use Core\Traits\SoftDelete;

/**
 * @todo: comment
 */
class User extends AbstractUser
{

    use SoftDelete;

    // const TABLENAME = 'foobar';

    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        protected string $password,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at,
        public bool $is_admin = false
    ) {
    }

}
