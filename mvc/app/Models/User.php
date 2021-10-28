<?php

namespace App\Models;

use Core\Models\AbstractUser;
use Core\Traits\SoftDelete;

/**
 * Class User
 *
 * @package app\Models
 */
class User extends AbstractUser
{

    /**
     * Hier laden wir den SoftDelete Trait, der die delete()- und find()-Methoden überschreibt, damit Objekte nicht
     * komplett gelöscht werden, sondern nur auf deleted gesetzt werden und damit die find()-Methode auch nur Objekte
     * findet, die nicht gelöscht sind.
     */
    use SoftDelete;

    public function __construct(
        /**
         * Wir verwenden hier Constructor Property Promotion, damit wir die ganzen Klassen Eigenschaften nicht 3 mal
         * angeben müssen.
         *
         * Im Prinzip definieren wir alle Spalten aus der Tabelle mit dem richtigen Datentyp.
         */
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

    /**
     * @return bool
     * @todo: implement
     */
    public function save(): bool
    {
    }
}
