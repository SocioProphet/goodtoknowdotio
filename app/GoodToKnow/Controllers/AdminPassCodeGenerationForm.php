<?php

namespace GoodToKnow\Controllers;

use GoodToKnow\Models\Community;

class AdminPassCodeGenerationForm
{
    function page()
    {
        global $is_logged_in;
        global $is_admin;
        global $sessionMessage;

        if (!$is_logged_in OR !$is_admin) {
            breakout(' You need to be the Admin to follow that request route. ');
        }


        /**
         * Here we need to have an enumerated array
         * of community objects. We will use this array
         * in the view template to generate each radio
         * input field. Each object has:
         *   - community_id
         *   - community_name
         *   - community_description
         */

        $db = get_db();

        // Community::find_all() should return the array we are looking for (see above)

        $community_array = Community::find_all($db, $sessionMessage);


        $html_title = 'Admin Pass-Code Generation Form';

        require VIEWS . DIRSEP . 'adminpasscodegenerationform.php';
    }
}