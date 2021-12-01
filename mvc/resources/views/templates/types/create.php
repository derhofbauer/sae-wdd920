<form action="<?php url_e("/types/store"); ?>" method="post">

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
            </div>
        </div>

    <div class="buttons mt-1">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php url_e('/types'); ?>" class="btn btn-danger">Cancel</a>
    </div>

</form>
