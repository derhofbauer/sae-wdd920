<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

/**
 * @todo: comment
 */
class Equipment extends AbstractModel
{
    use SoftDelete;

    public function __construct(
        public ?int $id = null,
        public string $name = '',
        public ?string $description = null,
        public int $units = 1,
        public ?int $type_id = null,
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null,
    ) {
    }

    /**
     * Objekt speichern.
     *
     * Wenn das Objekt bereits existiert hat, so wird es aktualisiert, andernfalls neu angelegt. Dadurch können wir eine
     * einzige Funktion verwenden und müssen uns nicht darum kümmern, ob das Objekt angelegt oder aktualisiert werden
     * muss.
     *
     * @return bool
     */
    public function save(): bool
    {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::getTablenameFromClassname();

        /**
         * Hat das Objekt bereits eine id, so existiert in der Datenbank auch schon ein Eintrag dazu und wir können es
         * aktualisieren.
         */
        if (!empty($this->id)) {
            /**
             * Query ausführen und Ergebnis direkt zurückgeben. Das kann entweder true oder false sein, je nachdem ob
             * der Query funktioniert hat oder nicht.
             */
            $result = $database->query(
                "UPDATE $tablename SET name = ?, description = ?, units = ?, type_id = ? WHERE id = ?",
                [
                    's:name' => $this->name,
                    's:description' => $this->description,
                    's:units' => $this->units,
                    's:type_id' => $this->type_id,
                    'i:id' => $this->id
                ]
            );

            return $result;
        } else {
            /**
             * Hat das Objekt keine id, so müssen wir es neu anlegen.
             */
            $result = $database->query("INSERT INTO $tablename SET name = ?, description = ?, units = ?, type_id = ?", [
                's:name' => $this->name,
                's:description' => $this->description,
                's:units' => $this->units,
                's:type_id' => $this->type_id,
            ]);

            /**
             * Ein INSERT Query generiert eine neue id, diese müssen wir daher extra abfragen und verwenden daher die
             * von uns geschrieben handleInsertResult()-Methode, die über das AbstractModel verfügbar ist.
             */
            $this->handleInsertResult($database);

            /**
             * Ergebnis zurückgeben. Das kann entweder true oder false sein, je nachdem ob der Query funktioniert hat
             * oder nicht.
             */
            return $result;
        }
    }

    /**
     * @return null
     * @todo: Implement type relation & form dropdowns for types!
     */
    public function type() {
        return null;
    }
}
