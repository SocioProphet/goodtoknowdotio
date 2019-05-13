<?php


namespace GoodToKnow\Controllers;


use GoodToKnow\Models\Post;
use GoodToKnow\Models\User;


class TransferPostOwnershipTransferIt
{
    public function page()
    {
        /**
         * Last function for TransferPostOwnershipTransferIt.
         *
         * Here we take the username submitted and use it to
         * make its id part of the record for for the post.
         */

        global $is_logged_in;
        global $sessionMessage;
        global $is_admin;
        global $saved_int02;  // Post id

        if (!$is_logged_in || !$is_admin || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        $db = db_connect($sessionMessage);
        if (!empty($sessionMessage) || $db === false) {
            $sessionMessage .= ' Database connection failed. ';
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        $username = (isset($_POST['username'])) ? $_POST['username'] : "";
        $username = trim($username);
        if (empty($username)) {
            $sessionMessage .= " You didn't give me a username. ";
            $_SESSION['message'] .= $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        // Get the user id which corresponds with the username.
        $user_object = User::find_by_username($db, $sessionMessage, $username);
        if (!$user_object) {
            $sessionMessage .= " Unexpected unable to retrieve target user's object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }
        $user_id = (int)$user_object->id;

        // Get the Post object.
        $post_object = Post::find_by_id($db, $sessionMessage, $saved_int02);
        if (!$post_object) {
            $sessionMessage .= " TransferPostOwnershipTransferIt::page says: Unexpected could not get a post object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        // Change the user_id to that of the new person.
        $post_object->user_id = $user_id;

        // Save the Post to the database.
        $result = $post_object->save($db, $sessionMessage);
        if ($result === false) {
            $sessionMessage .= " I aborted the process you were working on because I failed at saving the updated post
            object. ";
            $_SESSION['message'] = $sessionMessage;
            $_SESSION['saved_int01'] = 0;
            $_SESSION['saved_int02'] = 0;
            redirect_to("/ax1/Home/page");
        }

        // Report success.
        $sessionMessage .= " I have successfully updated the \"{$post_object->title}\" post's record so that now it
         belongs to <b>{$username}</b>. ";
        $_SESSION['message'] = $sessionMessage;
        redirect_to("/ax1/Home/page");
    }
}