<?php

namespace GoodToKnow\Controllers;

use GoodToKnow\Models\UserToCommunity;

class GiveComsChoicesProcessor
{
    function page()
    {
        global $saved_str01; // Has user's username
        global $saved_int01; // Has user's id

        require CONTROLLERINCLUDES . DIRSEP . 'get_the_submitted_community_ids.php';

        $db = get_db();


        /**
         * For each  comm id that was submitted
         * assign its community to the user.
         */

        /**
         * "The user" -- means The User we are attempting to assign new groups to.
         *
         * We know:
         *   saved_str01 -- contains the username
         *   saved_int01 -- contains the id of the user
         */

        /**
         * This loop will generate an array of UserToCommunity objects
         * to be used by the UserToCommunity::insert_multiple_objects method
         * so that we can insert all the UserToCommunity objects at once
         * instead of individually.
         */

        $array_of_usertocommunity_objects = [];

        /** @noinspection PhpUndefinedVariableInspection */

        foreach ($submitted_community_ids_array as $a_community_id) {
            $a_community_id = (int)$a_community_id;

            $usertocommunity_object_as_array = ['user_id' => $saved_int01, 'community_id' => $a_community_id];

            $array_of_usertocommunity_objects[] = UserToCommunity::array_to_object($usertocommunity_object_as_array);
        }


        /**
         * $array_of_usertocommunity_objects
         * Tested Good
         */

        /**
         * The goal now is to insert all these objects into the database.
         */

        $result = UserToCommunity::insert_multiple_objects($db, $sessionMessage, $array_of_usertocommunity_objects);

        if (!$result) {
            breakout(' In GiveComsChoicesProcessor encountered error due to
            UserToCommunity::array_to_object being unable to save the user_to_community records. ');
        }


        /**
         * Declare success.
         */

        breakout(" New communities were assigned to {$saved_str01}! ");
    }
}