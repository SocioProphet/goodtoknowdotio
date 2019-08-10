<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 9/29/18
 * Time: 4:43 PM
 */

namespace GoodToKnow\Controllers;


use GoodToKnow\Models\TopicToPost;
use function GoodToKnow\ControllerHelpers\integer_form_field_prep;


class CreateNewPostProcessor
{
    function page()
    {
        global $special_topic_array;
        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        if (isset($_POST['abort']) AND $_POST['abort'] === "Abort") {
            $sessionMessage .= " I aborted the task. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * We should have a post variable called
         * choice whose value is the topic id
         * the user intends to create a post in
         */

        /**
         * I can't assume this post variables exist so I do the following.
         */
        require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

        $chosen_topic_id = integer_form_field_prep('choice', 1, PHP_INT_MAX);

        if (is_null($chosen_topic_id)) {
            $sessionMessage .= " Your choice did not pass validation. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Make sure $chosen_topic_id is among the ids of $special_topic_array
         */
        if (!array_key_exists($chosen_topic_id, $special_topic_array)) {
            $sessionMessage .= " Unexpected error: topic id not found in topic array. ";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Save it in the session
         */
        $_SESSION['saved_int01'] = $chosen_topic_id;

        /**
         * Redirect
         *
         * Where we redirect depends on whether or not
         * there is more than one post in the chosen topic.
         */
        $db = db_connect($sessionMessage);
        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            redirect_to("/ax1/Home/page");
        }
        $posts = TopicToPost::get_posts_array_for_a_topic($db, $sessionMessage, $chosen_topic_id);
        if ($posts == false) $posts = [];
        $count = count($posts);

        if ($count > 0) {
            // We have some posts in our topic already
            redirect_to("/ax1/CreateNewPostInsertPoint/page");
        } else {
            // There are NO posts in our topic
            $_SESSION['saved_int02'] = 10500000;
            redirect_to("/ax1/CreateNewPostTitle/page");
        }
    }
}