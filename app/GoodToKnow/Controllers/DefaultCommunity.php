<?php

namespace GoodToKnow\Controllers;

class DefaultCommunity
{
    function page()
    {
        global $sessionMessage;
        global $special_community_array;
        global $html_title;

        kick_out_loggedoutusers();

        $html_title = 'Default Community';

        require VIEWS . DIRSEP . 'defaultcommunity.php';
    }
}