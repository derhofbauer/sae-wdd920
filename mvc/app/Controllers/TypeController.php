<?php

namespace App\Controllers;

use App\Models\Type;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Session;
use Core\Validator;
use Core\View;

/**
 * Type Controller
 */
class TypeController
{

    /**
     * Wir können die AuthMiddleware auch im Konstruktor aufrufen, wenn alle Actions dieselbe Methode der AuthMiddleware
     * aufgerufen hätten.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        AuthMiddleware::isAdminOrFail();
    }

    /**
     * Alle Einträge listen.
     */
    public function index()
    {
        /**
         * Alle Objekte über das Model aus der Datenbank laden.
         */
        $types = Type::all();

        /**
         * View laden und Daten übergeben.
         */
        View::render('types/index', [
            'types' => $types
        ]);
    }

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
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Gewünschtes Element über das zugehörige Model aus der Datenbank laden.
         */
        $type = Type::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('types/edit', [
            'type' => $type
        ]);
    }

    /**
     * Formulardaten aus dem Bearbeitungsformular entgegennehmen und verarbeiten.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function update(int $id)
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

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
            Redirector::redirect("/types/${id}");
        }

        /**
         * Gewünschten Type über das Model aus der Datenbank laden. Hier verwenden wir die findOrFail()-Methode aus
         * dem AbstractModel, die einen 404 Fehler ausgibt, wenn das Objekt nicht gefunden wird. Dadurch sparen wir uns
         * hier zu prüfen, ob ein Post gefunden wurde oder nicht.
         */
        $type = Type::findOrFail($id);

        /**
         * Sind keine Fehler aufgetreten legen aktualisieren wir die Werte des vorher geladenen Objekts ...
         */
        $type->fill($_POST);

        /**
         * Schlägt die Speicherung aus irgendeinem Grund fehl ...
         */
        if (!$type->save()) {
            /**
             * ... so speichern wir einen Fehler in die Session und leiten wieder zurück zum Bearbeitungsformular.
             */
            Session::set('errors', ['Speichern fehlgeschlagen.']);
        }

        /**
         * Wenn alles funktioniert hat, leiten wir zurück zur /home-Route.
         */
        Redirector::redirect("/types/${id}");
    }

    /**
     * Erstellungsformular anzeigen
     *
     * @throws \Exception
     */
    public function create()
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * View laden und Daten übergeben.
         */
        View::render('types/create');
    }

    /**
     * Formulardaten aus dem Erstellungsformular entgegennehmen und verarbeiten.
     *
     * @throws \Exception
     */
    public function store()
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

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
            Redirector::redirect("/types/create");
        }

        /**
         * Neuen Type erstellen und mit den Daten aus dem Formular befüllen.
         */
        $type = new Type();
        $type->fill($_POST);

        /**
         * Schlägt die Speicherung aus irgendeinem Grund fehl ...
         */
        if (!$type->save()) {
            /**
             * ... so speichern wir einen Fehler in die Session und leiten wieder zurück zum Bearbeitungsformular.
             */
            Session::set('errors', ['Speichern fehlgeschlagen.']);
            Redirector::redirect("/types/create");
        }

        /**
         * Wenn alles funktioniert hat, leiten wir zurück zur /home-Route.
         */
        Redirector::redirect('/types');
    }

    /**
     * Confirmation Page für die Löschung eines Types laden.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function delete(int $id)
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Type, der gelöscht werden soll, aus der DB laden.
         */
        $type = Type::findOrFail($id);

        /**
         * View laden und relativ viele Daten übergeben. Die große Anzahl an Daten entsteht dadurch, dass der
         * helpers/confirmation-View so dynamisch wie möglich sein soll, damit wir ihn für jede Delete Confirmation
         * Seite verwenden können, unabhängig vom Objekt, das gelöscht werden soll. Wir übergeben daher einen Typ und
         * einen Titel, die für den Text der Confirmation verwendet werden, und zwei URLs, eine für den
         * Bestätigungsbutton und eine für den Abbrechen-Button.
         */
        View::render('helpers/confirmation', [
            'objectType' => 'Type',
            'objectTitle' => $type->name,
            'confirmUrl' => BASE_URL . '/types/' . $type->id . '/delete/confirm',
            'abortUrl' => BASE_URL . '/types'
        ]);
    }

    /**
     * Type löschen.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function deleteConfirm(int $id)
    {
        /**
         * Prüfen, ob ein*e User*in eingeloggt ist und ob diese*r eingeloggte User*in Admin ist. Wenn nicht, geben wir
         * einen Fehler 403 Forbidden zurück. Dazu haben wir eine Art Middleware geschrieben, damit wir nicht immer
         * dasselbe if-Statement kopieren müssen, sondern einfach diese Funktion aufrufen können.
         */
        AuthMiddleware::isAdminOrFail();

        /**
         * Type, der gelöscht werden soll, aus DB laden.
         */
        $type = Type::findOrFail($id);
        /**
         * Type löschen.
         */
        $type->delete();

        /**
         * Erfolgsmeldung für später in die Session speichern.
         */
        Session::set('success', ['Typ erfolgreich gelöscht.']);
        /**
         * Weiterleiten zur Home Seite.
         */
        Redirector::redirect('/types');
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
        }

        /**
         * Fehler aus dem Validator zurückgeben.
         */
        return $validator->getErrors();
    }

}
