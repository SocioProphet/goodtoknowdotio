<?php

namespace GoodToKnow\Controllers;

use GoodToKnow\Models\Community;
use GoodToKnow\Models\CommunityToTopic;
use GoodToKnow\Models\Topic;
use GoodToKnow\Models\TopicToPost;
use GoodToKnow\Models\User;

class TransferPostOwnershipGetPost
{
    function page()
    {
        /**
         * This route will (1) determine which post the admin chose to do a transfer of ownership to,
         * (2) stores the post's id in the session, and
         * (3) presents a form asking the user if he
         * is sure this is the post he wants to transfer the ownership of.
         *
         * For step (3):
         * Based on the submitted post id the script will derive and present:
         *  - Community name
         *  - Topic name
         *  - Post title | extensionfortitle
         *  - Author username
         */

        global $html_title;
        global $long_title_of_post;

        require CONTROLLERINCLUDES . DIRSEP . 'admin_get_post.php';


        // (2) stores the post's id in the session

        /** @noinspection PhpUndefinedVariableInspection */

        $_SESSION['saved_int02'] = $chosen_post_id;


        // (3) presents a form asking the user if he is sure this is the post he wants to transfer the ownership of.

        /** @noinspection PhpUndefinedVariableInspection */

        $long_title_of_post = $post_object->title . " | " . $post_object->extensionfortitle;


        // Find the community name based on the post id. First derive the topic id from the post id.
        // Post id is $chosen_post_id

        /** @noinspection PhpUndefinedVariableInspection */

        $derived_topic_id = TopicToPost::derive_topic_id($db, $sessionMessage, $chosen_post_id);

        if ($derived_topic_id === false) {

            breakout(' TransferPostOwnershipGetPost::page() says: Failed to get the topic id. ');

        }


        // Second derive the community id from $derived_topic_id.

        $derived_community_id = CommunityToTopic::derive_community_id($db, $sessionMessage, $derived_topic_id);

        if ($derived_community_id === false) {

            breakout(' TransferPostOwnershipGetPost::page() says: Failed to get the community id. ');

        }


        // Third find the community name based on the community id.

        $community_object = Community::find_by_id($db, $sessionMessage, $derived_community_id);

        if ($community_object === false) {

            breakout(' TransferPostOwnershipGetPost::page() says: Failed to get the community object. ');

        }

        $community_name = $community_object->community_name;


        // Find the topic name based on $derived_topic_id

        $topic_object = Topic::find_by_id($db, $sessionMessage, $derived_topic_id);

        if ($topic_object === false) {

            breakout(' TransferPostOwnershipGetPost::page() says: Failed to get the topic object. ');

        }

        $topic_name = $topic_object->topic_name;


        // Find the author's username.

        $user_object = User::find_by_id($db, $sessionMessage, $post_object->user_id);

        if ($user_object === false) {

            breakout(' TransferPostOwnershipGetPost::page() says: Failed to get the user object. ');

        }

        $author_username = $user_object->username;


        // Call the view

        $html_title = 'Are you sure?';

        require VIEWS . DIRSEP . 'transferpostownershipgetpost.php';
    }
}