<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 9/14/18
 * Time: 3:35 PM
 */

namespace GoodToKnow\Controllers;


use GoodToKnow\Models\CommunityToTopic;
use GoodToKnow\Models\TopicToPost;


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
        global $communities_for_this_user;  // array (key: id of community, value: name of community)

        if (!$is_logged_in) {
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
        }

        $db = db_connect($sessionMessage);

        if (!empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
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
        if (!array_key_exists($community_id, $communities_for_this_user)) {
            $sessionMessage .= " Invalid community_id. ";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
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
        if (!$special_topic_array) {
            $sessionMessage .= " No topics in the specified community. ";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
        }

        if (array_key_exists($topic_id, $special_topic_array)) {
            $is_valid_topic = true;
        } else {
            $is_valid_topic = false;
        }

        if ($topic_id == 0) {
            $type_of_resource_being_requested = 'community';
            if ($post_id != 0) {
                $sessionMessage .= " Your resource request is defective. (errno 1)";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/LoginForm/page");
            }
        } elseif ($is_valid_topic) {
            $type_of_resource_being_requested = 'topic_or_post';
        } else {
            $sessionMessage .= " Your resource request is defective.  (errno 2)";
            $_SESSION['message'] .= $sessionMessage;
            redirect_to("/ax1/LoginForm/page");
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


        if ($type_of_resource_being_requested === 'topic_or_post') {
            if ($post_id === 0 && $topic_id !== 0) {
                $type_of_resource_being_requested = 'topic';
            } elseif ($post_id !== 0 && $topic_id !== 0) {
                $type_of_resource_being_requested = 'post';
            } else {
                $sessionMessage .= " Anomalous situation #2954. ";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/LoginForm/page");
            }
        }

        $is_valid_post = false;

        if ($type_of_resource_being_requested === 'post') {
            /**
             * But before we get started let's establish whether or not
             * $post_id is not some post id from amongst the posts belonging to the $topic_id
             */
            $special_post_array = TopicToPost::special_get_posts_array_for_a_topic($db, $sessionMessage, $topic_id);
            if (!$special_post_array) {
                $sessionMessage .= " Unable to get posts for the specified topic. ";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/LoginForm/page");
            }
            if (array_key_exists($post_id, $special_post_array)) {
                $is_valid_post = true;
            } else {
                $is_valid_post = false;
            }

            if ($post_id == 0 && $type_of_resource_being_requested === 'topic_or_post') {
                $type_of_resource_being_requested = 'topic';
            } elseif ($post_id != 0 && $type_of_resource_being_requested === 'community') {
                $sessionMessage .= " Your resource request is defective. (errno 3)";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/LoginForm/page");
            } elseif ($is_valid_topic && $is_valid_post) {
                $type_of_resource_being_requested = 'post';
            } else {
                $sessionMessage .= " Your resource request is defective.  (errno 4)";
                $_SESSION['message'] .= $sessionMessage;
                redirect_to("/ax1/LoginForm/page");
            }
        }

        /**
         * Debug
         */
        echo "\n<p>Begin debug</p>\n";
        echo "<p>Var_dump \$is_valid_post: </p>\n<pre>";
        var_dump($is_valid_post);
        echo "</pre>\n";
        echo "<p>Var_dump \$type_of_resource_being_requested: </p>\n<pre>";
        print_r($type_of_resource_being_requested);
        echo "</pre>\n";
        echo "<p>Var_dump \$sessionMessage: </p>\n<pre>";
        var_dump($sessionMessage);
        echo "</pre>\n";
        die("<p>community: {$community_id}, topic: {$topic_id}, post: {$post_id}</p>\n");



        /**
         * At this point we know that the request is valid and
         * we know which type of request it is. So now all we
         * need to do is put this information in the session and
         * redirect to the home page.
         */
        $_SESSION['type_of_resource_being_requested'] = $type_of_resource_being_requested;
        $_SESSION['community_id'] = $community_id;
        $_SESSION['topic_id'] = $topic_id;
        $_SESSION['post_id'] = $post_id;
        $_SESSION['message'] .= $sessionMessage;
        redirect_to("/ax1/LoginForm/page");
    }
}