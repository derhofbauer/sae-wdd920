<?php

namespace App\Controllers;

use App\Models\Room;
use Core\Session;
use Core\View;
use Core\Validator;
use Core\Helpers\Redirector;

/**
 * @todo: comment
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
        $room = Room::findOrFail($id);

        View::render('rooms/edit', [
            'room' => $room
        ]);
    }

    /**
     * Daten aus Formular entgegennehmen
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
        $validationErrors = $this->validateFormData();
        if (!empty($validationErrors)) {
            Session::set('errors', $validationErrors);
            Redirector::redirect("/rooms/${id}");
        }

        $room = Room::find($id);
        $room->fill($_POST);

        if (!$room->save()) {
            Session::set('errors', ['Speichern fehlgeschlagen.']);
            Redirector::redirect("/rooms/${id}");
        }

        Redirector::redirect('/home');
    }

    private function validateFormData(): array
    {
        $validator = new Validator();

        if (!empty($_POST)) {
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

        return $validator->getErrors();
    }

}
