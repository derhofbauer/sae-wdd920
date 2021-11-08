<!-- @todo: implement helper function for BASE_URL url generation -->
<form action="<?php echo BASE_URL . "/rooms/store" ?>" method="post">

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="room_nr">Room Number</label>
                <input type="text" maxlength="10" required class="form-control" placeholder="Room Number" name="room_nr">
            </div>
        </div>
    </div>

    <div class="form-group mt-1">
        <label for="location">Location</label>
        <textarea name="location" id="location" class="form-control" placeholder="Location"></textarea>
    </div>

    <!-- @todo: implement equipment dropdown -->

    <div class="buttons mt-1">
        <button type="submit" class="btn btn-primary">Save</button>
        <!-- @todo: change button route to rooms->index -->
        <a href="<?php
        echo BASE_URL . '/home'; ?>" class="btn btn-danger">Cancel</a>
    </div>

</form>
