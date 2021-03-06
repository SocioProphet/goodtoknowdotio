<?php

namespace GoodToKnow\Controllers;

class WriteOverATaxableIncomeEvent
{
    function page()
    {
        /**
         * This page is going to present a text box for entering a year_received value to be used to narrow down the
         * choices for which taxable_income_event to edit.
         */

        global $sessionMessage;
        global $html_title;

        kick_out_loggedoutusers();

        $html_title = 'Which year received?';

        require VIEWS . DIRSEP . 'writeoverataxableincomeevent.php';
    }
}