<?php


namespace GoodToKnow\Controllers;


class MakeARecurringPaymentRecord
{
    public function page()
    {
        /**
         * This feature enables any user to
         * create a database record in the
         * recurring_payment table. The process will
         * ask the user to ONLY supply a label
         * for the record. The remaining field values
         * will be supplied by a (not included)
         * editor for the record.
         */

        /**
         * This here script simply presents a
         * form for the user to supply the label
         * for the "to be created" recurring_payment
         * record.
         */

        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        $html_title = 'Create a New RecurringPayment Record';

        require VIEWS . DIRSEP . 'makearecurringpaymentrecord.php';
    }
}