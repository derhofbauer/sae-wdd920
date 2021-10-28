<?php

namespace App\Controllers;

use App\Models\Room;
use Core\Helpers\Redirector;
use Core\Session;
use Core\Validator;
use Core\View;

/**
 * Room Controller
 */
class RoomController
{

    /**
     * Bearbeitungsformular anzeigen
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function edit(int $id)
    {
        /**
         * Gewünschtes Element über das zugehörige Model aus der Datenbank laden.
         */
        $room = Room::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('rooms/edit', [
            'room' => $room
        ]);
    }

    /**
     * Formulardaten aus dem Bearbeitungsformular entgegennehmen und verarbeiten.
     *
     * @param int $id
     */
    public function update(int $id)
    {
        /**
         * 1) Daten validieren
         * 2) Model aus der DB abfragen, das aktualisiert werden soll
         * 3) Model in PHP überschreiben
         * 4) Model in DB zurückspeichern
         * 5) Redirect irgendwohin
         */

        /**
         * Nachdem wir exakt dieselben Validierungen durchführen für update und create, können wir sie in eine eigene
         * Methode auslagern und überall dort verwenden, wo wir sie brauchen.
         */
        $validationErrors = $this->validateFormData();

        /**
         * Sind Validierungsfehler aufgetreten ...
         */
        if (!empty($validationErrors)) {
            /**
             * ... dann speichern wir sie in die Session um sie in den Views dann ausgeben zu können ...
             */
            Session::set('errors', $validationErrors);
            /**
             * ... und leiten zurück zum Bearbeitungsformular. Der Code weiter unten in dieser Funktion wird dadurch
             * nicht mehr ausgeführt.
             */
            Redirector::redirect("/rooms/${id}");
        }

        /**
         * Gewünschten Room über das ROom-Model aus der Datenbank laden. Hier verwenden wir die findOrFail()-Methode aus
         * dem AbstractModel, die einen 404 Fehler ausgibt, wenn das Objekt nicht gefunden wird. Dadurch sparen wir uns
         * hier zu prüfen, ob ein Post gefunden wurde oder nicht.
         */
        $room = Room::find($id);

        /**
         * Sind keine Fehler aufgetreten legen aktualisieren wir die Werte des vorher geladenen Objekts ...
         */
        $room->fill($_POST);

        /**
         * Schlägt die Speicherung aus irgendeinem Grund fehl ...
         */
        if (!$room->save()) {
            /**
             * ... so speichern wir einen Fehler in die Session und leiten wieder zurück zum Bearbeitungsformular.
             */
            Session::set('errors', ['Speichern fehlgeschlagen.']);
            Redirector::redirect("/rooms/${id}");
        }

        /**
         * Wenn alles funktioniert hat, leiten wir zurück zur /home-Route.
         */
        Redirector::redirect('/home');
    }

    /**
     * Validierungen kapseln, damit wir sie überall dort, wo wir derartige Objekte validieren müssen, verwenden können.
     *
     * @return array
     */
    private function validateFormData(): array
    {
        /**
         * Neues Validator Objekt erstellen.
         */
        $validator = new Validator();

        /**
         * Gibt es überhaupt Daten, die validiert werden können?
         */
        if (!empty($_POST)) {
            /**
             * Daten validieren. Für genauere Informationen zu den Funktionen s. Core\Validator.
             *
             * Hier verwenden wir "named params", damit wir einzelne Funktionsparameter überspringen können.
             */
            $validator->textnum($_POST['name'], label: 'Name', required: true, max: 255);
            $validator->textnum($_POST['location'], label: 'Location');
            $validator->alphanumeric($_POST['room_nr'], label: 'Room Number', required: true, max: 10, min: 1);
            $validator->unique(
                $_POST['room_nr'],
                label: 'Room Number',
                table: Room::getTablenameFromClassname(),
                column: 'room_nr'
            );
        }

        /**
         * Fehler aus dem Validator zurückgeben.
         */
        return $validator->getErrors();
    }

}
