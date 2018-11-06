<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 9/14/18
 * Time: 3:35 PM
 */

namespace GoodToKnow\Controllers;


use GoodToKnow\Models\Community;
use GoodToKnow\Models\CommunityToTopic;
use GoodToKnow\Models\Post;
use GoodToKnow\Models\Topic;
use GoodToKnow\Models\TopicToPost;
use GoodToKnow\Models\User;


class SetHomePageCommunityTopicPost
{
    public function page(int $community_id, int $topic_id, int $post_id)
    {
        /**
         * This script runs when a user (on Home page) clicks a community,
         * a topic, or a post hyperlink. It does its thing then redirects
         * back to the Home page.
         *
         * "Its thing:"
         *  - Make sure the three parameters were specified in the request.
         *  - Make sure the community_id belongs to one of the user's communities.
         *  - Make sure the resource being requested exists (is NOT fictitious.)
         *  - Set session variables which let the home page know which
         *    community, topic, or post the user desires to see.
         */

        global $is_logged_in;
        global $sessionMessage;
        global $special_community_array;  // array (key: id of community, value: name of community)
        global $special_topic_array;
        global $special_post_array;
        global $post_content;

        if (!$is_logged_in) {
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
        }

        $db = db_connect($sessionMessage);

        if (!empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Make sure the three parameters were specified in the request.
         *
         * Actually it would cause Fatal Error if any of the parameters was not set
         *
         * Also, there's no need to check to see if the params are numeric.
         */

        /**
         * Make sure the community_id belongs to one of the user's communities.
         */
        if (!array_key_exists($community_id, $special_community_array)) {
            $sessionMessage .= " Invalid community_id. ";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        // Make sure the resource request is well formed and reasonable

        /**
         * Obviously the requested community exists since it's a
         * community the user belongs to.
         *
         * At this point we don't know if the user is requesting
         * a community, a topic, or a post. If the user requested
         * a community then $topic_id and $post_id must each be zero (0)
         */
        /**
         * At this point we know the user specified a valid $community_id.
         * We know that $topic_id is set. It SHOULD BE set to 0 or some
         * topic id form amongst the topics belonging to the $community_id.
         *
         * Let us make sure.
         */

        /**
         * But before we get started let's establish whether or not
         * $topic_id is not some topic id from amongst the topics belonging to the $community_id
         */
        $special_topic_array = CommunityToTopic::get_topics_array_for_a_community($db, $sessionMessage, $community_id);

        if ($special_topic_array && $topic_id != 0 && !array_key_exists($topic_id, $special_topic_array)) {
            $sessionMessage .= " Your resource request is defective.  (errno 6)";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        if (!$special_topic_array) {
            $special_topic_array = [];
        }

        if ($topic_id == 0) {
            $type_of_resource_requested = 'community';
            if ($post_id != 0) {
                $sessionMessage .= " Your resource request is defective. (errno 1)";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/Home/page");
            }
        } else {
            $type_of_resource_requested = 'topic_or_post';
        }


        /**
         * At this point we know we have a $community_id which is valid.
         * We know whether or not the request is for a community.
         * We know whether or not the request is for topic_or_post
         * we know that $topic_id is valid
         * We know that $post_id is set. It SHOULD BE set to 0 or some
         * post id from amongst the posts belonging to $topic_id.
         *
         * If the request is for a post then let us
         * make sure that post id is valid.
         */


        if ($type_of_resource_requested === 'topic_or_post') {
            // Either way we need this
            $special_post_array = TopicToPost::special_get_posts_array_for_a_topic($db, $sessionMessage, $topic_id);
            if (!$special_post_array) {
                $special_post_array = [];
            }
            // Which is it?
            if ($post_id === 0 && $topic_id !== 0) {
                $type_of_resource_requested = 'topic';
            } elseif ($post_id !== 0 && $topic_id !== 0) {
                $type_of_resource_requested = 'post';
            } else {
                $sessionMessage .= " Anomalous situation #2954. ";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/Home/page");
            }
        }

        if ($type_of_resource_requested === 'post') {
            if (!array_key_exists($post_id, $special_post_array)) {
                $sessionMessage .= " Your resource request is defective.  (errno 4)";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/Home/page");
            }

            /**
             * Get the post object for $post_id
             * and retrieve the post content from
             * the file system. Also, get the
             * posts author_username.
             */
            $post_object = Post::find_by_id($db, $sessionMessage, $post_id);
            if (!$post_object) {
                $sessionMessage .= " SetHomePageCommunityTopicPost::page says: Error 58498. ";
                $_SESSION['message'] = $sessionMessage;
                redirect_to("/ax1/Home/page");
            }
            $post_content = file_get_contents($post_object->html_file);
            if ($post_content === false) {
                $sessionMessage .= " Unable to read the post's html source file. ";
                $_SESSION['message'] = $sessionMessage;
                redirect_to("/ax1/Home/page");
            }
            $post_author_object = User::find_by_id($db, $sessionMessage, $post_object->user_id);
            if ($post_author_object === false) {
                $sessionMessage .= " Unable to get the post author object from the database. ";
                $_SESSION['message'] = $sessionMessage;
                redirect_to("/ax1/Home/page");
            }
        }

        /**
         * At this point we know that the request is valid and
         * we know which type of request it is.
         *
         * Now we need to store some things in the session and redirect.
         */
        if ($type_of_resource_requested === 'community') {
            // First get and store the community_name
            $community_object = Community::find_by_id($db, $sessionMessage, $community_id);
            $_SESSION['community_name'] = $community_object->community_name;
            $_SESSION['community_description'] = $community_object->community_description;
            // Then do the rest.
            $_SESSION['special_topic_array'] = $special_topic_array;
            $_SESSION['last_refresh_topics'] = time();
        } elseif ($type_of_resource_requested === 'topic') {
            // First get and store the community_name
            $community_object = Community::find_by_id($db, $sessionMessage, $community_id);
            $_SESSION['community_name'] = $community_object->community_name;
            $_SESSION['community_description'] = $community_object->community_description;
            // Second get and store the topic_name
            $topic_object = Topic::find_by_id($db, $sessionMessage, $topic_id);
            $_SESSION['topic_name'] = $topic_object->topic_name;
            $_SESSION['topic_description'] = $topic_object->topic_description;
            // Then do the rest.
            $_SESSION['special_topic_array'] = $special_topic_array;
            $_SESSION['last_refresh_topics'] = time();
            $_SESSION['special_post_array'] = $special_post_array;
            $_SESSION['last_refresh_posts'] = time();
        } else {
            // First get and store the community_name
            $community_object = Community::find_by_id($db, $sessionMessage, $community_id);
            $_SESSION['community_name'] = $community_object->community_name;
            $_SESSION['community_description'] = $community_object->community_description;
            // Second get and store the topic_name
            $topic_object = Topic::find_by_id($db, $sessionMessage, $topic_id);
            $_SESSION['topic_name'] = $topic_object->topic_name;
            $_SESSION['topic_description'] = $topic_object->topic_description;
            // Third store the post_name
            $_SESSION['post_name'] = $post_object->title;
            // Then do the rest.
            $_SESSION['special_topic_array'] = $special_topic_array;
            $_SESSION['last_refresh_topics'] = time();
            $_SESSION['special_post_array'] = $special_post_array;
            $_SESSION['last_refresh_posts'] = time();
            $_SESSION['post_content'] = $post_content;
            $_SESSION['last_refresh_content'] = time();
            $_SESSION['author_username'] = $post_author_object->username;
            $_SESSION['author_id'] = (int)$post_author_object->id;
        }
        $_SESSION['type_of_resource_requested'] = $type_of_resource_requested;
        $_SESSION['community_id'] = $community_id;
        $_SESSION['topic_id'] = $topic_id;
        $_SESSION['post_id'] = $post_id;
        $_SESSION['message'] .= $sessionMessage;
        redirect_to("/ax1/Home/page");
    }
}