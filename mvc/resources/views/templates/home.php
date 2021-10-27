<h2>Home</h2>

<table class="table table-striped">
    <thead>
    <th>#</th>
    <th>RNr.</th>
    <th>Name</th>
    <th>Location</th>
    <th>Actions</th>
    </thead>
    <?php
    /**
     * Alle Räume durchgehen und eine List ausgeben.
     */
    foreach ($rooms as $room): ?>

        <tr>
            <td><?php echo $room->id; ?></td>
            <td><?php echo $room->room_nr; ?></td>
            <td><?php echo $room->name; ?></td>
            <td><?php echo $room->location; ?></td>
            <td>
                <a href="<?php echo BASE_URL . "/rooms/$room->id"; ?>" class="btn btn-primary">Edit</a>
            </td>
        </tr>

    <?php
    endforeach; ?>
</table>
