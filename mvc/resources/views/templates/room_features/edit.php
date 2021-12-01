<form action="<?php url_e("/room-features/{$roomFeature->id}/update"); ?>" method="post">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Name" value="<?php
        echo $roomFeature->name; ?>" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea maxlength="255" required class="form-control" placeholder="Description" name="description" id="description"><?php echo $roomFeature->description; ?></textarea>
    </div>

    <div class="buttons mt-1">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php url_e('/room-features'); ?>" class="btn btn-danger">Cancel</a>
    </div>

</form>
