<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

/**
 * Class Post
 *
 * @package App\Models
 */
class Room extends AbstractModel
{

    const TABLENAME_ROOMFEATURES_MM = 'rooms_room_features_mm';

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
        public ?int $id = null,
        public string $name = '',
        public ?string $location = null,
        public string $room_nr = '',
        public string $images = '[]',
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null,
        private array $_roomFeatures = []
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
                "UPDATE $tablename SET name = ?, location = ?, room_nr = ?, images = ? WHERE id = ?",
                [
                    's:name' => $this->name,
                    's:location' => $this->location,
                    's:room_nr' => $this->room_nr,
                    's:images' => $this->images,
                    'i:id' => $this->id
                ]
            );

            /**
             * Raum Feature Daten aus $this->_roomFeatures speichern.
             */
            $this->saveRoomFeatures();

            return $result;
        } else {
            /**
             * Hat das Objekt keine id, so müssen wir es neu anlegen.
             */
            $result = $database->query("INSERT INTO $tablename SET name = ?, location = ?, room_nr = ?, images = ?", [
                's:name' => $this->name,
                's:location' => $this->location,
                's:room_nr' => $this->room_nr,
                's:images' => $this->images
            ]);

            /**
             * Raum Feature Daten aus $this->_roomFeatures speichern.
             */
            $this->saveRoomFeatures();

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
     * Setter für die Room Features.
     *
     * @param array $roomFeatures
     *
     * @return array
     */
    public function setRoomFeatures(array $roomFeatures): array
    {
        $this->_roomFeatures = $roomFeatures;

        return $this->_roomFeatures;
    }

    /**
     * Neue Liste an verknüpften Raum Features zuweisen.
     */
    private function saveRoomFeatures()
    {
        /**
         * Zunächst holen wir uns die aktuell zugewiesenen Raum Features aus der Datenbank.
         */
        $oldRoomFeatures = $this->roomFeatures();

        /**
         * Dann bereiten wir uns zwei Arrays vor, damit wir die zu löschenden Zuweisungen und jene, die unverändert
         * bleiben sollen, speichern können. Daraus ergibt sich, dass alle weiteren, die in $this->_roomFeatures
         * vorhanden sind, neu angelegt werden müssen.
         */
        $roomFeaturesToDelete = [];
        $roomFeaturesToNotBeTouched = [];

        /**
         * Nun gehen wir alle alten Zuweisungen durch ...
         */
        foreach ($oldRoomFeatures as $oldRoomFeature) {
            /**
             * ... und prüfen, ob sie auch in den neuen Raum Features vorkommen sollen.
             */
            if (!in_array($oldRoomFeature->id, $this->_roomFeatures)) {
                /**
                 * Wenn nein, soll die Zuweisung gelöscht werden.
                 */
                $roomFeaturesToDelete[] = $oldRoomFeature->id;
            } else {
                /**
                 * Wenn ja, soll sie weiterhin bestehen bleiben.
                 */
                $roomFeaturesToNotBeTouched[] = $oldRoomFeature->id;
            }
        }

        /**
         * Nun berechnen wir uns die Differenz der drei Arrays, wobei alle Werte aus dem ersten Array das Ergebnis
         * bilden, die in keinem der weiteren Arrays vorhanden sind. Diese RoomFeatures müssen neu zugewiesen werden.
         */
        $roomFeaturesToAdd = array_diff($this->_roomFeatures, $roomFeaturesToDelete, $roomFeaturesToNotBeTouched);

        /**
         * Nun gehen wir alle zu löschenden und neu anzulegenden RoomFeature Verbindungen durch und führen die
         * entsprechende Aktion aus.
         */
        foreach ($roomFeaturesToDelete as $roomFeatureToDelete) {
            $this->detachRoomFeature($roomFeatureToDelete);
        }
        foreach ($roomFeaturesToAdd as $roomFeatureToAdd) {
            $this->attachRoomFeature($roomFeatureToAdd);
        }
    }

    /**
     * Relation zu RoomFeatures
     *
     * @return array
     */
    public function roomFeatures(): array
    {
        /**
         * Über das RoomFeature Model alle zugehörigen RoomFeatures abrufen.
         */
        return RoomFeature::findByRoom($this->id);
    }

    /**
     * Verknüpfung zu einem RoomFeature aufheben.
     *
     * @param int $roomFeatureId
     *
     * @return bool
     */
    public function detachRoomFeature(int $roomFeatureId): bool
    {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::TABLENAME_ROOMFEATURES_MM;

        /**
         * Query ausführen.
         */
        $result = $database->query("DELETE FROM $tablename WHERE room_id = ? AND room_feature_id = ?", [
            'i:room_id' => $this->id,
            'i:room_feature_id' => $roomFeatureId
        ]);

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return $result;
    }

    /**
     * Verknüpfung zu einem RoomFeature herstellen.
     *
     * @param int $roomFeatureId
     *
     * @return bool
     */
    public function attachRoomFeature(int $roomFeatureId): bool
    {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::TABLENAME_ROOMFEATURES_MM;

        /**
         * Query ausführen.
         */
        $result = $database->query("INSERT INTO $tablename SET room_id = ?, room_feature_id = ?", [
            'i:room_id' => $this->id,
            'i:room_feature_id' => $roomFeatureId
        ]);

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return $result;
    }

    /**
     * @return array
     * @todo: comment
     */
    public function getImages(): array
    {
        return json_decode($this->images);
    }

    /**
     * @return bool
     * @todo: comment
     */
    public function hasImages(): bool
    {
        return !empty($this->getImages());
    }

    /**
     * @param array $images
     *
     * @return array
     * @todo: comment
     */
    public function addImages(array $images): array
    {
        $currentImages = $this->getImages();
        $currentImages = array_merge($currentImages, $images);
        $this->setImages($currentImages);

        return $currentImages;
    }

    /**
     * @param array $images
     *
     * @return array
     * @todo: comment
     */
    public function removeImages(array $images): array
    {
        $currentImages = $this->getImages();
        $filteredImages = array_filter($currentImages, function ($image) use ($images) {
            if (in_array($image, $images)) {
                return false;
            }
            return true;
        });
        $this->setImages($filteredImages);

        return $filteredImages;
    }

    /**
     * @param array $images
     *
     * @return array
     * @todo: comment
     */
    public function setImages(array $images): array
    {
        $this->images = json_encode(array_values($images));

        return $this->getImages();
    }
}
