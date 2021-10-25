<div class="container errors">
    <?php
    /**
     * @todo: comment
     */
    foreach (\Core\Session::getAndForget('errors', []) as $error): ?>
        <p class="alert alert-danger"><?php echo $error; ?></p>
    <?php endforeach; ?>
</div>
