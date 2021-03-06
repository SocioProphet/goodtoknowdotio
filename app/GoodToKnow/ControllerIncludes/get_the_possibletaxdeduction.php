<?php

use GoodToKnow\Models\PossibleTaxDeduction;
use function GoodToKnow\ControllerHelpers\integer_form_field_prep;

global $sessionMessage;

global $user_id;

global $timezone;

kick_out_loggedoutusers();


/**
 * 1) Store the submitted possible_tax_deduction id in the session.
 */

require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

$id = integer_form_field_prep('choice', 1, PHP_INT_MAX);

$_SESSION['saved_int01'] = $id;


/**
 * 2) Retrieve the possible_tax_deduction object with that id from the database.
 */

$db = get_db();

$object = PossibleTaxDeduction::find_by_id($db, $sessionMessage, $id);

if (!$object) {

    breakout(' Unexpectedly, I could not find that possible tax deduction. ');

}


/**
 * 3) Make sure the object belongs to this user.
 */

if ($object->user_id != $user_id) {

    breakout(' Error 01544111. ');

}
