<?php

use GoodToKnow\Models\Bitcoin;
use function GoodToKnow\ControllerHelpers\integer_form_field_prep;

global $sessionMessage;

global $timezone;

global $user_id;

kick_out_loggedoutusers();


/**
 * Determines the id of the bitcoin record from $_POST['choice'] and stores it in $_SESSION['saved_int01'].
 */

require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

$chosen_id = integer_form_field_prep('choice', 1, PHP_INT_MAX);

$_SESSION['saved_int01'] = $chosen_id;


/**
 * Retrieve the Bitcoin object with that id from the database.
 */

$db = get_db();

$bitcoin_object = Bitcoin::find_by_id($db, $sessionMessage, $chosen_id);

if (!$bitcoin_object) {

    breakout(' Unexpectedly I could not find that bitcoin record. ');

}


/**
 * Verify that this object belongs to the user.
 */

if ($bitcoin_object->user_id != $user_id) {

    breakout(' Error 8006667. ');

}
