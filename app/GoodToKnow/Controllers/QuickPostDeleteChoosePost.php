<?php


namespace GoodToKnow\Controllers;


class QuickPostDeleteChoosePost
{
    public function page()
    {
        /**
         * The goal is to present a form
         * with radio buttons for admin
         * to choose the post to delete.
         * We are ONLY presenting posts
         * found in the topic which was
         * already selected.
         * If we can't find any posts then
         * we'll store a session message
         * and redirect back home.
         *
         * For each post we will show the
         * complete name of the post along
         * with the username of its author.
         */

        global $is_logged_in;
        global $sessionMessage;
        global $is_admin;
        global $saved_int01;        // id of topic

        if (!$is_logged_in || !$is_admin || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        $db = db_connect($sessionMessage);

        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }


    }
}