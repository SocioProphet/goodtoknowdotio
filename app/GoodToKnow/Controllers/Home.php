<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 8/22/18
 * Time: 9:09 PM
 */

namespace GoodToKnow\Controllers;


class Home
{
    public function page()
    {
        global $is_logged_in;
        global $sessionMessage;
        global $is_admin;
        global $user_id;                    // int value
        global $role;                       // string value
        global $community_name;             // string value
        global $community_id;               // int value
        global $communities_for_this_user;  // array (key: id of community, value: name of community)
        global $topic_id;                   // int value
        global $post_id;                    // int value
        global $saved_str01;                // string value (temporary storage)
        global $saved_str02;
        global $type_of_resource_being_requested;  // result of running SetHomePageCommunityTopicPost

        if (!$is_logged_in) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/InfiniteLoopPrevent/page");
        }

        $html_title = 'GoodToKnow.io';

        require VIEWS . DIRSEP . 'home.php';
    }
}