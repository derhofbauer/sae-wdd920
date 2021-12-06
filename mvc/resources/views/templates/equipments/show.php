<div class="row">
    <div class="col">
        <p>
            <strong>Name</strong>
        </p>
        <div>
            <?php
            echo $equipment->name; ?>
        </div>
    </div>

    <div class="col">
        <p>
            <strong>Units</strong>
        </p>
        <div>
            <?php
            echo $equipment->units; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>
            <strong>Description</strong>
        </p>
        <div><?php
            echo $equipment->description; ?></div>
    </div>

    <div class="col">
        <p>
            <strong>Type</strong>
        </p>
        <div><?php
            echo $equipment->type(); ?></div>
    </div>
</div>

<div class="buttons mt-1">
    <a href="<?php
    echo BASE_URL . '/equipments'; ?>" class="btn btn-danger">zurück</a>

    <?php
    if (\Core\Middlewares\AuthMiddleware::isLoggedIn()): ?>
        <a href="<?php
        echo BASE_URL . "/equipments/$equipment->id/add-to-cart"; ?>" class="btn btn-success">Add To Cart (referrer)</a>
        <a href="<?php
        echo BASE_URL . "/equipments/$equipment->id/add-to-cart-get?redirect=/equipments/$equipment->id/show"; ?>" class="btn btn-success">Add To Cart (GET)</a>
        <a href="<?php
        echo BASE_URL . "/api/equipments/$equipment->id/add-to-cart-ajax"; ?>" class="btn btn-success add-to-cart">Add To Cart (Ajax)</a>
    <?php
    endif; ?>
</div>
