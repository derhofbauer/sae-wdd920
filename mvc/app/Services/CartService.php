<?php

namespace App\Services;

use App\Models\Equipment;

/**
 * @todo: comment
 */
class CartService
{
    const SESSION_KEY = 'equipment-cart';

    public static function add(Equipment $equipment)
    {
        self::init();

        if (self::has($equipment)) {
            $_SESSION[self::SESSION_KEY][$equipment->id]++;
        } else {
            $_SESSION[self::SESSION_KEY][$equipment->id] = 1;
        }
    }

    public static function remove(Equipment $equipment)
    {
        self::init();

        if (self::has($equipment)) {
            $_SESSION[self::SESSION_KEY][$equipment->id]--;

            if ($_SESSION[self::SESSION_KEY][$equipment->id] <= 0) {
                self::removeAll($equipment);
            }
        }
    }

    public static function removeAll(Equipment $equipment)
    {
        self::init();

        if (self::has($equipment)) {
            unset($_SESSION[self::SESSION_KEY][$equipment->id]);
        }
    }

    public static function get()
    {
        self::init();

        $equipments = [];
        foreach ($_SESSION[self::SESSION_KEY] as $equipmentId => $number) {
            $equipment = Equipment::findOrFail($equipmentId);
            $equipment->count = $number;
            $equipments[] = $equipment;
        }

        return $equipments;
    }

    public static function getCount(): int
    {
        self::init();
        $count = 0;

        foreach ($_SESSION[self::SESSION_KEY] as $equipmentId => $number) {
            $count = $count + $number;
        }

        return $count;
    }

    private static function init()
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    private static function has(Equipment $equipment): bool
    {
        return isset($_SESSION[self::SESSION_KEY][$equipment->id]);
    }

    public static function destroy()
    {
        if (isset($_SESSION[self::SESSION_KEY])) {
            unset($_SESSION[self::SESSION_KEY]);
        }
    }
}
