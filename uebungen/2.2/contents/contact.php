<?php

/**
 * Validierung der Formulardaten
 */

/**
 * Zu allererst bereiten wir uns ein Array vor, in das wir die Fehler, die
 * weiter unten vielleicht auftreten werden, reinspeichern können. Am Ende der
 * Validierung gehen wir den Fehler-Array dann durch und generieren Fehler im
 * HTML.
 */
$errors = [];

/**
 * Wir wollen die Validierung nur dann ausführen, wenn auch wirklich ein Formular abgeschickt wurde. Sonst würde sie
 * auch ausgeführt werden, wenn man das Formular nur aufruft und das bringt nichts. Daher prüfen wir, ob die Daten
 * aus dem Button übertragen wurden - dann können wir davon ausgehen, dass die restlichen Formulardaten auch vorhanden
 * sind.
 */
if (isset($_POST['do-submit'])) {
    /**
     * Feld "name" validieren
     *
     * Nun prüfen wir, ob
     *  + der "name" POST-Paramater NICHT gesetzt ist,
     *  + ODER kürzer als 2 Zeichen
     *  + ODER länger als 255 Zeichen.
     * Wenn eine oder mehrere dieser
     * Bedingunden zutrefen, dann ist der Wert nicht valide und wir fügen einen
     * Fehler in den Fehler-Array hinzu.
     */
    if (
        !isset($_POST['name'])
        || strlen($_POST['name']) < 2
        || strlen($_POST['name']) > 255
    ) {
        /**
         * Ist der Wert nicht valide, schreiben wir einen Fehler in den vorbereiteten
         * Array.
         */
        $errors['name'] = 'Der Name muss mindestens 2 Zeichen und maximal 255 Zeichen lang sein.';
    }

    /**
     * Feld "email" validieren (ohne regex)
     *
     * Wir prüfen, ob
     *  + die E-Mail Adresse NICHT eingegeben wurde
     *  + ODER ob sie kein @ enthält
     *  + ODER ob sie kürzer ist als 5 Zeichen (a@b.c wären 5 Zeichen)
     *  + ODER ob sie keinen Punkt nach dem @ enthält
     *  + ODER ob sie ein @ und direkt darauf einen . enthält
     *  + ODER ob sie mit einem . beginnt oder endet.
     * Trifft ein oder mehrere Bedingungen zu, so ist der eingegebene Wert nicht valide und wir schreiben einen Fehler.
     */
    if (
        !isset($_POST['email'])
        || !str_contains($_POST['email'], '@')
        || strlen($_POST['email']) < 5
        /**
         * Diese Bedingung ist von innen nach außen zu lesen:
         *  + strpos($_POST['email'], '@') + 1 <-- zunächst holen wir uns einmal den Index des @ im Text und rechnen 1 dazu,
         *    weil wir ein Zeichen zusätzlich nach dem @ haben wollen, bevor wir auf den Punkt prüfen.
         *  + (substr($_POST['email'], strpos($_POST['email'], '@') + 1) <-- nun holen wir uns den Sub-String ab dem @+1 aus
         *    der Email-Adresse.
         *  + !str_contains(substr($_POST['email'], strpos($_POST['email'], '@') + 1), '.') <-- und nun prüfen wir, ob der
         *    Sub-String ab @+1 einen Punkt enthält.
         *
         * Wir decken hier nicht den Fall ab, dass zwei Punkte nach dem @ eingegeben werden könnten - dieser Fall würde hier
         * also nicht als invalide gewertet werden.
         */
        || !str_contains(substr($_POST['email'], strpos($_POST['email'], '@') + 1), '.')
        || str_contains($_POST['email'], '@.')
        || str_ends_with($_POST['email'], '.')
        || str_starts_with($_POST['email'], '.')
        || str_starts_with($_POST['email'], '@')
    ) {
        $errors['email1'] = '[manual] Bitte geben Sie eine valide E-Mail Adresse ein.';
    }

    /**
     * Feld "email" validieren (mit regex)
     *
     * Die Regular Expression ist folgendermaßen aufgebaut:
     *  + / und /gm beginnen und beenden die Expression. Die g und m Modifikatoren geben dabei an, dass nicht nach dem
     *  ersten Treffer die Suche abgebrochen wird (g) und dass der String mehrere Zeilen haben kann, die alle einzeln
     *  betrachtet werden (m). Beide Modifikatoren machen in unserem Fall keinen Unterschied.
     *  + [\w.]+ sucht alle Word-Characters (a-z, A-Z, 0-9, _), da kommt dann noch der Punkt dazu und aus dieser Menge
     *  wollen wir mit dem + mindestens 1 Zeichen.
     *  + dann erwarten wir ein @
     *  + dann nochmal einen Word-Charakter, diesmal aber ohne Punkt
     *  + mit \. dann einen Punkt (der Punkt wird hier escaped)
     *  + dann mit [a-z]{2,} mindestens 2 Zeichen aus der Menge a-z
     *
     * preg_match() prüft dann den Wert auf die Expression und gibt im Erfolgsfall 1 zurück.
     */
    $pattern = '/[\w.]+@[\w]+\.[a-z]{2,}/m';
    if (!isset($_POST['email']) || preg_match($pattern, $_POST['email']) !== 1) {
        $errors['email2'] = '[regex] Bitte geben Sie eine valide E-Mail Adresse ein.';
    }

    /**
     * Hier prüfen wir, ob ein eingegebener Wert einer Telefonnummer entsprechen kann:
     *
     * + (\+?|0{0,2}) = ein Plus ODER 0-2 Nuller
     * + [0-9 ]{1,3} = 1-3 Ziffern (Ländervorwahl)
     * + [0-9 \/()-]+ = mindestens eine Ziffer, Leerzeichen, Slash, Klammern oder Bindestriche
     */
    $pattern = '/(\+?|0{0,2})[0-9 ]{1,3}[0-9 \/()-]+/m';
    if (!isset($_POST['phone']) || preg_match($pattern, $_POST['phone']) !== 1) {
        $errors['phone'] = 'Bitte geben Sie eine gültige Telefonnummer ein.';
    }


    /**
     * Nun prüfen wir ob das Topic nicht übergeben wurde oder ob der Default-Wert übergeben wurde und schreiben bei
     * Bedarf einen Fehlermeldung.
     */
    if (!isset($_POST['topic']) || $_POST['topic'] === '_default') {
        $errors['topic'] = 'Bitte wählen Sie ein Topic aus.';
    }

    /**
     * Wenn die message nicht gesetzt wurde oder kürzer ist als 10 Zeichen, dann schreiben wir noch einen Fehler.
     */
    if (!isset($_POST['message']) || strlen($_POST['message']) < 10) {
        $errors['message'] = 'Bitte geben Sie eine Nachricht mit mindestens 10 Zeichen ein.';
    }

    /**
     * Eine Checkbox, die nicht angehakerlt ist, wird nicht übergeben an den Server, wenn sie angehakerlt ist und kein
     * value-Attribut hat, dann hat sie den Wert "on" (string). Hier prüfen wir, ob die Checkbox nicht angehakerlt ist
     * oder den falschen Wert hat und schreiben bei Bedarf einen Fehler.
     */
    if (!isset($_POST['newsletter']) || $_POST['newsletter'] !== "on") {
        $errors['newsletter'] = 'Sie MÜSSEN den Newsletter abonnieren.';
    }
}

/**
 * Get error by name and print it.
 *
 * @param string $name
 */
function printError (string $name)
{
    /**
     * Zunächst holen wir die $errors Variable in den Scope der Funktion. das ist nicht sonderlich elegant, aber es tut
     * seinen Zweck.
     */
    global $errors;

    /**
     * Dann prüfen wir, ob ein Fehler für den als Funktionsparameter übergebenen Wert $name existiert. In der
     * Validierung speichern wir nämlich Fehler nicht einfach nur noch in $errors hinein, sondern vergeben auch selbst
     * Indizex, damit die Fehler einfacher Formularfeldern zugeordnet werden können.
     */
    if (isset($errors[$name])) {
        echo '<div class="error" style="background-color: #f86161; padding: 5px">' . $errors[$name] . '</div>';
    }
}

/**
 * Get old value and print it.
 *
 * @param string $name
 */
function old (string $name)
{
    /**
     * Hier ersetzen wir den Ternary Operator für die vorher geschickten Formulardaten, mit einem normalen if.
     */
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>

<?php
/**
 * Wir wollen das Formular nur dann anzeigen, wenn es noch nicht abgeschickt wurde ODER wenn es Fehler gibt.
 */
if (!empty($errors) || !isset($_POST['do-submit'])): ?>
    <form method="post" novalidate>
        <div>
            <?php
            /**
             * Statt in jedem Formular-value einen eigenen Ternary Operator zu verwenden, haben wir eine Funktion dafür
             * geschrieben, die wir einfach nur noch verwenden müssen.
             */
            ?>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" minlength="2" required value="<?php old('name'); ?>">
            <?php
            /**
             * Damit wir nicht überalle den selben Code-Block hinkopieren müssen, der Fehler generiert, haben wir dafür
             * auch eine Funktion geschrieben, die wir überall aufrufen können, wo wir sie brauchen.
             */
            printError('name'); ?>
        </div>

        <div>
            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required value="<?php old('email'); ?>">
            <?php printError('email1'); ?>
            <?php printError('email2'); ?>
        </div>

        <div>
            <label for="phone">Telefonnummer</label>
            <input type="tel" name="phone" id="phone" required value="<?php old('phone'); ?>">
            <?php printError('phone'); ?>
        </div>

        <div>
            <label for="topic">Thema</label>
            <select name="topic" id="topic">
                <option value="_default" disabled selected>Bitte Thema auswählen ...</option>
                <option value="help">Hilfe & Support</option>
                <option value="complaint">Beschwerde</option>
                <option value="misc">Sonstiges</option>
            </select>
            <?php printError('topic'); ?>
        </div>

        <div>
            <label for="message">Nachricht</label>
            <textarea name="message" id="message" required><?php old('message'); ?></textarea>
            <?php printError('message'); ?>
        </div>

        <div>
            <label for="newsletter">
                <input type="checkbox" name="newsletter" id="newsletter"> Newsletter?
            </label>
            <?php printError('newsletter'); ?>
        </div>

        <div>
            <button type="submit" name="do-submit" value="do-submit">Senden</button>
        </div>
    </form>
<?php else: ?>
    Vielen dank für ihre Nachricht.
<?php endif; ?>
