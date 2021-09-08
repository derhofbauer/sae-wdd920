<?php

/**
 * Validierung der Formulardaten
 */
$errors = [];

if (
    !isset($_POST['name'])
    || strlen($_POST['name']) < 2
    || strlen($_POST['name']) > 255
) {
    $errors[] = 'Der Name muss mindestens 2 Zeichen und maximal 255 Zeichen lang sein.';
}

/**
 * Regeln für Email
 * + @
 * + . nach @, aber nicht direkt danach
 * + mind 5 zeichen: a@b.c
 */
if (
    !isset($_POST['email'])
    || !str_contains($_POST['email'], '@')
    || strlen($_POST['email']) < 5
    || !str_contains(substr($_POST['email'], strpos($_POST['email'], '@') + 1), '.')
    || str_contains($_POST['email'], '@.')
    || str_ends_with($_POST['email'], '.')
    || str_starts_with($_POST['email'], '.')
    || str_starts_with($_POST['email'], '@')
) {
    $errors[] = '[manual] Bitte geben Sie eine valide E-Mail Adresse ein.';
}

$pattern = '/[\w.]+@[\w]+\.[a-z]{2,}/gm';
if (preg_match($pattern, $_POST['email']) !== 1) {
    $errors[] = '[regex] Bitte geben Sie eine valide E-Mail Adresse ein.';
}
?>

<form method="post" novalidate>
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" minlength="2" required>
    </div>

    <div>
        <label for="email">E-Mail</label>
        <input type="email" name="email" id="email" required>
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
        <textarea name="message" id="message" required></textarea>
    </div>

    <div>
        <label for="newsletter">
            <input type="checkbox" name="newsletter" id="newsletter"> Newsletter?
        </label>
    </div>

    <div>
        <button type="submit">Senden</button>
    </div>
</form>
