<div class="card">
    <div class="card-header">Raumbuchung: <?php echo $room->name; ?></div>
    <div class="card-body">
        <form action="<?php echo BASE_URL . "/rooms/$room->id/booking/do"; ?>" method="post">
            <div class="form-group">
                <label for="date">Datum</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>

            <?php
            /**
             * @todo: disable unavailable slots
             * @todo: comment
             */
            $bookingStart = \Core\Config::get('app.booking-start', 8);
            $bookingEnd = \Core\Config::get('app.booking-end', 16);

            for($i = $bookingStart; $i < $bookingEnd; $i++): ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="timeslots[]" id="timeslot[<?php echo $i; ?>]" value="<?php echo $i; ?>">
                    <label for="timeslot[<?php echo $i; ?>]" class="form-check-label">
                        <?php
                        /**
                         * @todo: comment
                         */
                        echo str_pad($i, 2, '0', STR_PAD_LEFT) . ':00-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ':00'; ?>
                    </label>
                </div>
            <?php endfor; ?>
            <button class="btn btn-primary" type="submit">Buchen!</button>
        </form>
    </div>
</div>
