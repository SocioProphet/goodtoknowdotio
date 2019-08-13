<?php


namespace GoodToKnow\Controllers;


use function GoodToKnow\ControllerHelpers\get_readable_time;
use function GoodToKnow\ControllerHelpers\integer_form_field_prep;
use function GoodToKnow\ControllerHelpers\readable_amount_of_money;
use GoodToKnow\Models\BankingTransactionForBalances;


class OmitABankingTransactionForBalancesDelete
{
    function page()
    {
        /**
         * 1) Store the submitted banking_transaction_for_balances record id in the session.
         * 2) Retrieve the banking_transaction_for_balances object with that id from the database.
         * 3) Present a form which is populated with data from the banking_transaction_for_balances object
         *    and asks for approval for deletion to proceed.
         */

        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        if (isset($_POST['abort']) AND $_POST['abort'] === "Abort") {
            $sessionMessage .= " I aborted the task. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        /**
         * 1) Store the submitted banking_transaction_for_balances record id in the session.
         */
        require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

        $chosen_id = integer_form_field_prep('choice', 1, PHP_INT_MAX);

        if (is_null($chosen_id)) {
            $sessionMessage .= " Your choice did not pass validation. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        $_SESSION['saved_int01'] = $chosen_id;

        /**
         * 2) Retrieve the banking_transaction_for_balances object with that id from the database.
         */
        $db = db_connect($sessionMessage);
        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }
        $object = BankingTransactionForBalances::find_by_id($db, $sessionMessage, $chosen_id);
        if (!$object) {
            $sessionMessage .= " Unexpectedly I could not find that banking_transaction_for_balances record. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        /**
         * 3) Present a form (populated with data from the object)
         *    which asks for approval for deletion to proceed.
         *
         * Note: As usual we will pretty up the fields prior to showing them in the view.
         *       We will only show the following fields' values:
         *         - label
         *         - amount
         *         - time
         */
        require_once CONTROLLERHELPERS . DIRSEP . 'get_readable_time.php';
        require_once CONTROLLERHELPERS . DIRSEP . 'readable_amount_of_money.php';

        $object->time = get_readable_time($object->time);
        $object->amount = readable_amount_of_money($object->currency, $object->amount);

        $html_title = 'Are you sure?';

        require VIEWS . DIRSEP . 'omitabankingtransactionforbalancesdelete.php';
    }
}