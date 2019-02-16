<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 2019-01-13
 * Time: 22:01
 */

namespace GoodToKnow\Controllers;


class GiveComsChoicesProcessor
{
    public function page()
    {
        global $is_logged_in;
        global $is_admin;
        global $sessionMessage;
        global $saved_str01; // Has user's username
        global $saved_int01; // Has user's id

        if (!$is_logged_in || !$is_admin || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }
        /**
         * Now we know the ids of the communities the administrator
         * wants the user to belong to. The goal is to assign these
         * communities to the user.
         */

        /**
         * $_POST array looks something like this:
         *
         * array(5) {
         *   ["choice-1"]=> string(1) "3"
         *   ["choice-2"]=> string(1) "8"
         *   ["choice-3"]=> string(2) "12"
         *   ["choice-4"]=> string(2) "15"
         *   ["submit"]=> string(6) "Submit"
         * }
         */

        /**
         * Instead what we need is an array like this:
         *
         * array(4) {
         *   [0]=> string(1) "3"
         *   [1]=> string(1) "8"
         *   [2]=> string(2) "12"
         *   [3]=> string(2) "15"
         * }
         */

        if (!isset($_POST) || empty($_POST) || !is_array($_POST)) {
            $sessionMessage .= " Unexpected deficiencies in the _POST array. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        $submitted_community_ids_array = [];
        foreach ($_POST as $item) {
            if (is_numeric($item)) {
                $submitted_community_ids_array[] = $item;
            }
        }

        if (empty($submitted_community_ids_array)) {
            $sessionMessage .= " You did not submit any community ids. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Debug Code
         */
        echo "\n<p>Begin debug</p>\n";
        echo "<br><p>Var_dump \$submitted_community_ids_array: </p>\n<pre>";
        var_dump($submitted_community_ids_array);
        die("<br><p>End debug</p>\n");
    }
}