<?php

namespace GoodToKnow\Controllers;

use function GoodToKnow\ControllerHelpers\integer_form_field_prep;

class LiquidateYearsPossibleTaxDeductionsGetYear
{
    function page()
    {
        /**
         * 1) Validate the submitted year_paid.
         * 2) Delete the possible_tax_deduction(s/plural) which have the specified year_paid.
         * 3) Give confirmation of deletion.
         */

        global $sessionMessage;

        kick_out_nonadmins();

        $db = get_db();


        /**
         *  1) Validate the submitted year_paid.
         */

        require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

        $year_paid = integer_form_field_prep('year_paid', 1992, 65535);


        /**
         * 2) Delete the possible_tax_deduction(s/plural) which have the specified year_paid.
         */

        $num_affected_rows = 0;

        $sql = 'DELETE FROM `possible_tax_deduction` WHERE `year_paid` = ';

        $sql .= $db->real_escape_string($year_paid);

        try {

            $db->query($sql);

            $query_error = $db->error;

            if (!empty(trim($query_error))) {
                breakout(' The delete failed because: ' . htmlspecialchars($query_error, ENT_NOQUOTES | ENT_HTML5) . ' ');
            }

            $num_affected_rows = $db->affected_rows;

        } catch (\Exception $e) {

            $sessionMessage .= ' LiquidateYearsPossibleTaxDeductionsGetYear page() exception: ' .
                htmlspecialchars($e->getMessage(), ENT_NOQUOTES | ENT_HTML5) . ' ';

        }

        if (!empty($sessionMessage)) {

            breakout('');

        }


        /**
         * 3) Give confirmation of deletion.
         */

        $message = " The purge of Possible Tax Write-offs for <b>{$year_paid}</b> has deleted <b>";
        $message .= $num_affected_rows . "</b> records. ";
        breakout($message);
    }
}