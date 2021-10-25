<?php

namespace Core\Traits;

use Core\Database;

/**
 * @todo: comment
 */
trait SoftDelete
{

    public function delete(): bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        $result = $database->query("UPDATE $tablename SET deleted_at = CURRENT_TIME() WHERE id = ?", [
            'i:id' => $this->id
        ]);

        return $result;
    }

    public static function all(?string $orderBy = null, ?string $direction = null): array
    {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        if ($orderBy === null) {
            $result = $database->query("SELECT * FROM $tablename WHERE deleted_at IS NULL");
        } else {
            $result = $database->query(
                "SELECT * FROM $tablename WHERE deleted_at IS NULL ORDER BY $orderBy $direction"
            );
        }

        return self::handleResult($result);
    }

}
