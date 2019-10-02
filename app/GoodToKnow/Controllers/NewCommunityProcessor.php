<?php

namespace GoodToKnow\Controllers;

use function GoodToKnow\ControllerHelpers\standard_form_field_prep;

class NewCommunityProcessor
{
    function page()
    {
        global $sessionMessage;

        kick_out_loggedoutusers();

        require_once CONTROLLERHELPERS . DIRSEP . 'standard_form_field_prep.php';

        $community_name = standard_form_field_prep('community_name', 1, 200);

        $community_description = standard_form_field_prep('community_description', 1, 230);

        $_SESSION['saved_str01'] = $community_name;
        $_SESSION['saved_str02'] = $community_description;

        redirect_to("/ax1/NewCommunitySave/page");
    }
}