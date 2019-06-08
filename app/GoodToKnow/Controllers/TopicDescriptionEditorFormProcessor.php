<?php


namespace GoodToKnow\Controllers;


use GoodToKnow\Models\Topic;


class TopicDescriptionEditorFormProcessor
{
    public function page()
    {
        /**
         * The purpose is to:
         *  1) Read $_POST['text']
         *     (which is the edited community's description.)
         *  2) Remove any HTML tags found in $_POST['text'].
         *  3) Validate the suitability of $_POST['text']
         *     as a topic description.
         *  4) Get a copy of the Topic object.
         *  5) Makes sure the description is escaped for suitability
         *     to being included in an sql statement. This may be
         *     taken care of automatically by the GoodObject class
         *     function I'll be using but make sure.
         *  6) Replace the Topic's current description with the new one.
         *  7) Update the database with this Topic object.
         */

        global $is_logged_in;
        global $is_admin;
        global $sessionMessage;
        global $saved_str01;                // The topic's name
        global $saved_int01;                // The topic's id

        if (!$is_logged_in || !$is_admin || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        if (isset($_POST['abort']) AND $_POST['abort'] === "Abort") {
            $sessionMessage .= " You've aborted the task! Session variables reset. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         *  1) Read $_POST['text']
         *     (which is the edited topic's description.)
         */
        $edited_description = (isset($_POST['text'])) ? $_POST['text'] : '';
        if (!isset($_POST['text']) || trim($edited_description) === '') {
            $sessionMessage .= " The edited comment was not saved because nothing (or blank space) was submitted. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         *  2) Remove any HTML tags found in $_POST['text'].
         *  3) Validate the suitability of $_POST['text']
         *     as a topic description.
         */
        $result = Topic::is_topic_description($sessionMessage, $edited_description);
        if ($result === false) {
            $sessionMessage .= " I aborted the process you were working on because the text submitted did not comply. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         *  4) Get a copy of the Topic object.
         */
        $db = db_connect($sessionMessage);
        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }
        $topic_object = Topic::find_by_id($db, $sessionMessage, $saved_int01);
        if (!$topic_object) {
            $sessionMessage .= " Unexpected failed to retrieve the topic object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         *  5) Makes sure the description is escaped for suitability
         *     to being included in an sql statement. This may be
         *     taken care of automatically by the GoodObject class
         *     function I'll be using but make sure.
         *
         *  Yes this is t.c.o. automatically. So, don't worry about it!
         */

        /**
         *  6) Replace the Topic's current description with the new one.
         */
        $topic_object->topic_description = $edited_description;

        /**
         *  7) Update the database with this Topic object.
         */
        $result = $topic_object->save($db, $sessionMessage);
        if ($result === false) {
            $sessionMessage .= " I aborted the process you were working on because I failed at saving the updated topic object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_str01'] = "";
            redirect_to("/ax1/Home/page");
        }

        /**
         * Report success.
         */
        $sessionMessage .= " I have successfully updated {$saved_str01}'s record. ";
        $_SESSION['message'] = $sessionMessage;
        $_SESSION['saved_int01'] = 0;
        $_SESSION['saved_str01'] = "";
        redirect_to("/ax1/Home/page");
    }
}