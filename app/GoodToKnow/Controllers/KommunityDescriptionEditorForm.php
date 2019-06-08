<?php


namespace GoodToKnow\Controllers;


use GoodToKnow\Models\Community;


class KommunityDescriptionEditorForm
{
    public function page()
    {
        global $is_logged_in;
        global $is_admin;
        global $sessionMessage;
        global $saved_str01; // community name
        global $saved_int01; // community id

        if (!$is_logged_in || !$is_admin || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         * Goals for this function:
         *  1) Retrieve the Community object for the community
         *     whose description the admin wants to edit.
         *  2) Present a (pre-filled with current description)
         *     form for editing.
         */
        $db = db_connect($sessionMessage);
        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        // 1) Retrieve the Community object for the community whose description the admin wants to edit.
        $community_object = Community::find_by_id($db, $sessionMessage, $saved_int01);
        if (!$community_object) {
            $sessionMessage .= " I was unexpectedly unable to retrieve target community's object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        // 2) Present a (pre-filled with current description) form for editing.
        $html_title = "Community's Description Editor";

        require VIEWS . DIRSEP . 'kommunitydescriptioneditorform.php';
    }
}