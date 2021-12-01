<h2>Cart</h2>

<table class="table table-striped">
    <thead>
    <th>#</th>
    <th>Name</th>
    <th>Description</th>
    <th># in cart</th>
    <th>Actions</th>
    </thead>
    <?php
    /**
     * Alle Räume durchgehen und eine List ausgeben.
     */
    foreach ($equipments as $equipment): ?>

        <tr>
            <td><?php
                echo $equipment->id; ?></td>
            <td>
                <a href="<?php
                url_e("/equipments/$equipment->id/show"); ?>">
                    <?php
                echo $equipment->name; ?>
                </a>
            </td>
            <td><?php
                echo $equipment->description; ?></td>
            <td><?php
                echo $equipment->count; ?></td>
            <td>
                <a href="<?php
                url_e("/equipments/$equipment->id/add-to-cart"); ?>" class="btn btn-primary">+</a>
                <a href="<?php
                url_e("/equipments/$equipment->id/remove-from-cart"); ?>" class="btn btn-primary">-</a>
                <a href="<?php
                url_e("/equipments/$equipment->id/remove-all-from-cart"); ?>" class="btn btn-danger">Remove from
                                                                                                     cart</a>
            </td>
        </tr>

    <?php
    endforeach; ?>
</table>

<?php
if (\App\Models\User::isLoggedIn()): ?>
    <a href="<?php
    url_e('/checkout/summary'); ?>" class="btn btn-primary">Checkout</a>
<?php
endif; ?>
