<h2>
    Type
    <?php
    if (\App\Models\User::isLoggedIn()): ?>
        <a href="<?php
        echo BASE_URL; ?>/types/create" class="btn btn-primary btn-sm">New</a>
    <?php
    endif; ?>
</h2>

<table class="table table-striped">
    <thead>
    <th>#</th>
    <th>Name</th>
    <th>Actions</th>
    </thead>
    <?php
    /**
     * Alle Räume durchgehen und eine List ausgeben.
     */
    foreach ($types as $type): ?>

        <tr>
            <td><?php
                echo $type->id; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>/types/<?php echo $type->id; ?>/show"><?php
                    echo $type->name; ?>
                </a>
            </td>
            <td>
                <?php
                if (\Core\Middlewares\AuthMiddleware::isAdmin()): ?>
                    <a href="<?php
                    echo BASE_URL . "/types/$type->id"; ?>" class="btn btn-primary">Edit</a>

                    <a href="<?php
                    echo BASE_URL . "/types/$type->id/delete"; ?>" class="btn btn-danger">Delete</a>
                <?php
                endif; ?>
            </td>
        </tr>

    <?php
    endforeach; ?>
</table>
