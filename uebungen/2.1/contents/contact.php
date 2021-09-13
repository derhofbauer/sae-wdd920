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
 * @todo: comment
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
        $errors[] = 'Der Name muss mindestens 2 Zeichen und maximal 255 Zeichen lang sein.';
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
        $errors[] = '[manual] Bitte geben Sie eine valide E-Mail Adresse ein.';
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
        $errors[] = '[regex] Bitte geben Sie eine valide E-Mail Adresse ein.';
    }

    /**
     * @todo: comment
     */
    if (!isset($_POST['topic']) || $_POST['topic'] === '_default') {
        $errors[] = 'Bitte wählen Sie ein Topic aus.';
    }

    /**
     * @todo: comment
     */
    if (!isset($_POST['message']) || strlen($_POST['message']) < 10) {
        $errors[] = 'Bitte geben Sie eine Nachricht ein.';
    }

    /**
     * @todo: comment
     */
    if (!isset($_POST['newsletter']) || $_POST['newsletter'] !== "on") {
        $errors[] = 'Sie MÜSSEN den Newsletter abonnieren.';
    }
}
?>

<?php
/**
 * @todo: comment
 */
if (!empty($errors) || !isset($_POST['do-submit'])): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p class="error" style="background-color: #c96868; padding: 5px">
                <?php echo $error; ?>
            </p>
        <?php endforeach; ?>
    </div>

    <form method="post" novalidate>
        <div>
            <!--
            bedingung ? dann-das : sonst-das
            -->
            <label for="name">Name</label>
            <input type="text" name="name" id="name" minlength="2" required value="<?php echo(isset($_POST['name']) ? $_POST['name'] : ''); ?>">
        </div>

        <div>
            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required value="<?php echo(isset($_POST['email']) ? $_POST['email'] : ''); ?>">
        </div>

        <div>
            <label for="topic">Thema</label>
            <select name="topic" id="topic">
                <option value="_default" disabled selected>Bitte Thema auswählen ...</option>
                <option value="help">Hilfe & Support</option>
                <option value="complaint">Beschwerde</option>
                <option value="misc">Sonstiges</option>
            </select>
        </div>

        <div>
            <label for="message">Nachricht</label>
            <textarea name="message" id="message" required><?php echo(isset($_POST['message']) ? $_POST['message'] : ''); ?></textarea>
        </div>

        <div>
            <label for="newsletter">
                <input type="checkbox" name="newsletter" id="newsletter"> Newsletter?
            </label>
        </div>

        <div>
            <button type="submit" name="do-submit" value="do-submit">Senden</button>
        </div>
    </form>
<?php else: ?>
    Vielen dank für ihre Nachricht.
<?php endif; ?>
