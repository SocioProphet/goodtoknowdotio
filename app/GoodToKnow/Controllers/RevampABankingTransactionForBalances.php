<?php

namespace GoodToKnow\Controllers;

class RevampABankingTransactionForBalances
{
    function page()
    {
        /**
         * This page is going to present some radio buttons for answering the question of which
         * time range the user wants to see further choices of transactions for.
         */

        global $sessionMessage;
        global $html_title;

        kick_out_loggedoutusers();

        $html_title = 'Which time range for filtering your transaction choices?';

        require VIEWS . DIRSEP . 'revampabankingtransactionforbalances.php';
    }
}