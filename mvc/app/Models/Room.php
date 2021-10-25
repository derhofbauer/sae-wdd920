<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

/**
 * @todo: comment
 */
class Room extends AbstractModel
{

    use SoftDelete;

    public function __construct(
        public int $id,
        public string $name,
        public ?string $location,
        public string $room_nr,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at
    ) {
    }

}
