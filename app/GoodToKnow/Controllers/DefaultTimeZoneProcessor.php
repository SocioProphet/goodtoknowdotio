<?php

namespace GoodToKnow\Controllers;

use GoodToKnow\Models\User;
use function GoodToKnow\ControllerHelpers\standard_form_field_prep;
use function GoodToKnow\ControllerHelpers\timezone_form_field_prep;

class DefaultTimeZoneProcessor
{
    function page()
    {
        /**
         * Modify the database record for this user table using the submitted timestamp.
         * Also, switch to the default time zone in the session.
         */

        global $sessionMessage;

        global $user_id;

        kick_out_loggedoutusers();

        require_once CONTROLLERHELPERS . DIRSEP . 'timezone_form_field_prep.php';

        $timezone = timezone_form_field_prep('timezone');

        $db = get_db();

        $user_object = User::find_by_id($db, $sessionMessage, $user_id);

        if (!$user_object) {

            breakout(' Expected submission of choice not found. ');

        }

        $user_object->timezone = $timezone;

        $was_updated = $user_object->save($db, $sessionMessage);

        if (!$was_updated) {

            breakout(' Failed to update your user record. ');

        }

        $_SESSION['timezone'] = $timezone;


        // User will know default community by logging out then in.

        breakout(" Your default timezone has been changed to <b>{$timezone}</b>. ");
    }
}