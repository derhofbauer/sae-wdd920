<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><?php echo \Core\Config::get('app.app-name'); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/home">Home</a>
                </li>
                <li class="nav-item">

                </li>
            </ul>
            <?php
            /**
             * @todo: comment whole block
             */
            if (\App\Models\User::isLoggedIn()):?>
                <div class="d-flex">
                    Eingeloggt: <?php echo \App\Models\User::getLoggedIn()->username; ?>
                    (<a href="<?php echo BASE_URL ?>/logout">Logout</a>)
                </div>
            <?php else: ?>
                <a class="btn btn-primary" href="<?php echo BASE_URL; ?>/login">Login</a>
            <?php endif; ?>
            <!--<form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>-->
        </div>
    </div>
</nav>
