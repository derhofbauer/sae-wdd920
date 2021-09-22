<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formularvalidierung</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>

<form method="post" class="container">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>

    <div class="form-group">
        <label for="select">Some values</label>
        <?php

        /**
         * Zunächst definieren wir uns die Werte für die Option Tags, damit wir diese dynamisch generieren können und
         * jeweils prüfen, ob einer davon ausgewählt war.
         */
        $options = [
            'value-1' => 'Option 1',
            'value-2' => 'Option 2',
            'value-3' => 'Option 3'
        ];

        ?>
        <select name="select" id="select" class="form-control">
            <option value="_default">Default</option>
            <?php
            /**
             * Nun gehen wir alle $options durch.
             */
            foreach ($options as $htmlValue => $label): ?>
                <?php
                /**
                 * Wir wollen den <option>-Tag, der beim letzten Absenden des Formulars ausgewählt war, wieder auswählen.
                 * Daher definieren wir uns einen Partikel, den wir mit einem Wert belegen, sofern der Tag ausgewählt
                 * sein soll. Der Wert ist das gesamte selected-Binary Attribute.
                 */
                $selectedParticle = '';

                /**
                 * War der <option>-Tag beim letzten Absenden ausgewählt, so generieren wir das selected-Binary
                 * Attribute hier mit PHP und schreiben es weiter unten in den <option>-Tag.
                 */
                if (isset($_POST['select']) && $_POST['select'] === $htmlValue) {
                    $selectedParticle = ' selected';
                }
                ?>
                <option value="<?php echo $htmlValue; ?>"<?php echo $selectedParticle; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>
            <?php
            /**
             * Hier machen wir genau das selbe wie oben, aber mit dem Ternary Operator. Wenn die Checkbox angehakerlt
             * war, dann setzen wir das Binary Attribute checked, andernfalls setzten wir einen leeren String.
             */
            ?>
            <input type="checkbox" name="checkbox" id="checkbox"<?php echo (isset($_POST['checkbox']) && $_POST['checkbox'] === 'on') ? ' checked' : ''; ?>>
            Checkbox
        </label>

    </div>

    <button type="submit">Senden</button>

</form>

</body>
</html>
