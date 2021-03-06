<?php

namespace GoodToKnow\Controllers;

class FineTuneACommoditySold
{
    function page()
    {
        /**
         * This page is going to present a text box for entering a tax_year value to be used
         * to narrow down the choices for which CommoditySold to edit.
         */

        global $sessionMessage;
        global $html_title;

        kick_out_loggedoutusers();

        $html_title = 'Which tax year?';

        require VIEWS . DIRSEP . 'finetuneacommoditysold.php';
    }
}