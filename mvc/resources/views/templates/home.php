<h2>Home</h2>

<ul>
    <?php
    /**
     * Alle Räume durchgehen und eine List ausgeben.
     */
    foreach ($rooms as $room): ?>

        <li><?php echo "$room->room_nr: $room->name"; ?></li>

    <?php endforeach; ?>
</ul>
