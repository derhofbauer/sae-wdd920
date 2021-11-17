<?php

namespace Core\Models;

/**
 * @todo: comment
 */
class DateTime extends \DateTime
{
    const MYSQL_DATETIME = 'Y-m-d H:i:s';

    public function __toString()
    {
        return $this->format(self::MYSQL_DATETIME);
    }

}
