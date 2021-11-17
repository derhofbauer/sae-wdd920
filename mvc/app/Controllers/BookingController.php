<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Models\DateTime;
use Core\Session;
use Core\View;

/**
 * @todo: comment
 */
class BookingController
{

    public function selectSlots(int $id)
    {
        AuthMiddleware::isLoggedInOrFail();

        $room = Room::find($id);

        /**
         * Formular anzeigen, damit Zeitslots gebucht werden können.
         */
        View::render('bookings/time', [
            'room' => $room
        ]);
    }

    public function bookSlots(int $id)
    {
        AuthMiddleware::isLoggedInOrFail();

        /**
         * @todo: Hier müsste eigentlich validiert werden!
         */

        if (isset($_POST['timeslots']) && !empty($_POST['timeslots'])) {
            $dates = [];

            foreach ($_POST['timeslots'] as $timeslot) {
                $startDate = new DateTime($_POST['date']);
                $startDate->setTime($timeslot, 0);

                $endDate = clone $startDate;
                $endDate->modify('+1 hour');

                $dates[] = [
                    'start' => $startDate,
                    'end' => $endDate
                ];
            }

            $allTimeslotsAvailable = true;
            foreach ($dates as $startAndEndDate) {
                if (Booking::existsForRoomAndTime($id, $startAndEndDate['start'], $startAndEndDate['end'])) {
                    $allTimeslotsAvailable = false;
                    break;
                }
            }

            if ($allTimeslotsAvailable === true) {
                foreach ($dates as $startAndEndDate) {
                    $booking = new Booking();
                    $booking->fill([
                        'user_id' => User::getLoggedIn()->id,
                        'foreign_table' => 'rooms',
                        'foreign_id' => $id,
                        'time_from' => $startAndEndDate['start'],
                        'time_to' => $startAndEndDate['end']
                    ]);
                    $booking->save();
                }
                Session::set('success', ['Timeslots erfolgreich gebucht!']);
                Redirector::redirect("/rooms");
            }

            Session::set('errors', ['Einer der gewählten Timeslots ist bereits vergeben.']);
        } else {
            Session::set('errors', ['Keine Timeslots ausgewählt.']);
        }

        Redirector::redirect("/rooms/$id/booking/time");
    }

}
