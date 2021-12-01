<form action="<?php url_e("/equipments/store"); ?>" method="post">

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="units">Units</label>
                <input type="number" min="1" step="1" required class="form-control" placeholder="Units" name="units" id="units">
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-select" name="type_id" id="type" required>
                    <option value="_default" hidden>Bitte auswählen ...</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php _e($type->id); ?>"><?php _e($type->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group mt-1">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
            </div>
        </div>
    </div>

    <div class="buttons mt-1">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php url_e('/rooms'); ?>" class="btn btn-danger">Cancel</a>
    </div>

</form>
