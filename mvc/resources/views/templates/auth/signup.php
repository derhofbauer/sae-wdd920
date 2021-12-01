<div class="col-4">
    <form action="<?php url_e('/sign-up/do'); ?>" method="post">

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_repeat">Password wiederholen</label>
            <input type="password" name="password_repeat" id="password_repeat" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Registrieren</button>
        <a href="<?php url_e('/login'); ?>" class="btn btn-link">Login</a>
    </form>
</div>
