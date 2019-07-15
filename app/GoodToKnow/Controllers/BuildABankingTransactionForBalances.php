<?php


namespace GoodToKnow\Controllers;


class BuildABankingTransactionForBalances
{
    public function page()
    {
        /**
         * This feature enables any user to
         * create a database record in the
         * banking_transaction_for_balances table. The process will
         * ask the user to ONLY supply a banking_transaction_for_balances
         * label + time . And the remaining field values
         * will be supplied by an (not included)
         * editor for the record.
         */

        /**
         * This here script simply presents a
         * form for the user to supply the banking_transaction_for_balances
         * label + time for the "to be created" banking_transaction_for_balances
         * record.
         */

        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        $html_title = 'Create a New Banking Transaction For Balances';

        require VIEWS . DIRSEP . 'buildabankingtransactionforbalances.php';
    }
}