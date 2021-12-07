<?php

namespace App\Controllers;

use App\Models\Booking;
use Core\Helpers\Redirector;

/**
 * Checkin Controller
 */
class CheckinController
{

    /**
     * Equipment wieder einbuchen.
     *
     * @param int $id Booking Id
     *
     * @return void
     */
    public function returnEquipment (int $id) {
        /**
         * [x] Booking, das gelöscht werden soll, aus DB laden
         * [x] Equipment ID aus Booking laden
         * [x] Equipment zu der ID aus DB laden
         * [x] Booking löschen
         * [x] Equipment->units erhöhen um 1
         * [x] Equipment in DB zurückspeichern
         * [x] Redirect
         */

        /**
         * Booking, das gelöscht werden soll, aus DB laden.
         */
        $booking = Booking::find($id);
        /**
         * Zugehöriges Equipment laden.
         */
        $equipment = $booking->bookable();

        /**
         * Booking Eintrag löschen.
         */
        $booking->delete();

        /**
         * Equipment Units wieder um 1 rauf drehend in die DB zurückspeichern.
         */
        $equipment->units = $equipment->units + 1; // IDENT MIT $equipment->units =+ 1; IDENT MI $equipment->units++;
        $equipment->save();

        /**
         * Redirect zum Profil.
         */
        Redirector::redirect('/profile');
    }

}
