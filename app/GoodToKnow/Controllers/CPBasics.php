<?php

namespace GoodToKnow\Controllers;

class CPBasics
{
    function page()
    {
        global $sessionMessage;
        global $special_community_array;
        global $type_of_resource_requested;
        global $is_admin;
        global $is_guest;
        global $show_poof;
        global $html_title;

        kick_out_loggedoutusers();

        $page = 'CPBasics';

        $show_poof = true;

        $html_title = 'Basics';

        $sessionMessage .= ' Manage account and posts. ';

        require VIEWS . DIRSEP . 'cpbasics.php';
    }
}