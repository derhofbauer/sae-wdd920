<?php

namespace Core\Models;

use Core\Database;

/**
 * @todo: comment
 */
abstract class AbstractModel
{

    public function save()
    {
    }

    public static function all(?string $orderBy = null, ?string $direction = null): array
    {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        if ($orderBy === null) {
            $result = $database->query("SELECT * FROM $tablename");
        } else {
            $result = $database->query("SELECT * FROM $tablename ORDER BY $orderBy $direction");
        }

        return self::handleResult($result);
    }

    public function delete(): bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        $result = $database->query("DELETE FROM $tablename WHERE id = ?", [
            'i:id' => $this->id
        ]);

        return $result;
    }

    public static function getTablenameFromClassname(): string
    {
        $calledClass = get_called_class(); // App\Models\User

        if (defined("$calledClass::TABLENAME")) {
            return $calledClass::TABLENAME;
        }

        $particles = explode('\\', $calledClass); // ['App', 'Models', 'User']
        $classname = array_pop($particles); // 'User'
        $tablename = strtolower($classname) . 's'; // 'users'

        return $tablename;
    }

    public static function handleResult(array $results): array
    {
        $objects = [];

        foreach ($results as $result) {
            $calledClass = get_called_class();
            $objects[] = new $calledClass(...$result);
        }

        return $objects;
    }

    public static function handleUniqueResult(array $results): ?object
    {
        $objects = self::handleResult($results);

        if (empty($objects)) {
            return null;
        }

        return $objects[0];
    }

    public static function find(int $id): ?object
    {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        $result = $database->query("SELECT * FROM $tablename WHERE `id` = ?", [
            'i:id' => $id
        ]);

        return self::handleUniqueResult($result);
    }

    public static function findOrFail(int $id): ?object
    {
        $result = self::find($id);

        if (empty($result)) {
            throw new \Exception('Model not found', 404);
        }

        return $result;
    }
}
