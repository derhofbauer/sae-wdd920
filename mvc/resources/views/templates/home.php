<h2>Home</h2>

<ul>
    <?php
    /**
     * @todo: comment
     */
    foreach ($rooms as $room): ?>

    <li><?php echo "$room->room_nr: $room->name";?></li>

    <?php
    endforeach; ?>
</ul>
