<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

/**
 * Class Post
 *
 * @package App\Models
 */
class Room extends AbstractModel
{

    /**
     * Wir innerhalb einer Klasse das use-Keyword verwendet, so wird damit ein Trait importiert. Das kann man sich
     * vorstellen wie einen Import mittels require, weil die Methoden, die im Trait definiert sind, einfach in die
     * Klasse, die den Trait verwendet, eingefügt werden, als ob sie in der Klasse selbst definiert worden wären.
     * Das hat den Vorteil, dass Methoden, die in mehreren Klassen vorkommen, zentral definiert und verwaltet werden
     * können in einem Trait, und dennoch überall dort eingebunden werden, wo sie gebraucht werden, ohne Probleme mit
     * komplexen und sehr verschachtelten Vererbungen zu kommen.
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
        public string $name,
        public ?string $location,
        public string $room_nr,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at
    ) {
    }

}
