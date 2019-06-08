<?php


namespace GoodToKnow\Controllers;


class InitializeABitcoinRecord
{
    public function page()
    {
        /**
         * This feature enables any user to
         * create a database record in the
         * bitcoin table. The process will
         * ask the user to ONLY supply a bitcoin
         * address and the remaining field values
         * will be supplied by an (not included)
         * editor for the record.
         */

        /**
         * This here script simply presents a
         * form for the user to supply the bitcoin
         * address for the "to be created" bitcoin
         * record.
         */

        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        $html_title = 'Create a New Bitcoin Record';

        require VIEWS . DIRSEP . 'initializeabitcoinrecord.php';
    }
}