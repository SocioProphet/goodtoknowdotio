<?php

namespace GoodToKnow\Controllers;

class CPTransactions
{
    function page()
    {
        global $sessionMessage;
        global $special_community_array;
        global $type_of_resource_requested;
        global $is_admin;
        global $is_guest;

        kick_out_loggedoutusers();

        $page = 'CPTransactions';

        $show_poof = true;

        $html_title = 'Transactions';

        $sessionMessage .= ' Manage <em>transactions</em> of bank accounts. ';

        require VIEWS . DIRSEP . 'cptransactions.php';
    }
}