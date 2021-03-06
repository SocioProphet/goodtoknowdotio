<?php

namespace GoodToKnow\Controllers;

use GoodToKnow\Models\MessageToUser;

class Inbox
{
    function page()
    {
        global $user_id;
        global $sessionMessage;
        global $is_admin;
        global $is_guest;
        global $show_poof;
        global $html_title;
        global $special_community_array;
        global $community_id;
        global $community_name;
        global $topic_id;
        global $topic_name;
        global $post_id;
        global $post_name;
        global $type_of_resource_requested;
        global $author_username;

        kick_out_loggedoutusers();

        $db = get_db();

        $html_title = 'Inbox';

        $page = 'Inbox';

        $show_poof = true;

        $inbox_messages_array = MessageToUser::get_array_of_message_objects_for_a_user($db, $sessionMessage, $user_id);


        /**
         * Replace (in each Message) the user_id and created with a username and a datetime.
         */

        if (!empty($inbox_messages_array)) {
            $return = MessageToUser::replace_attributes($db, $sessionMessage, $inbox_messages_array);

            if ($return === false) {
                breakout(' Unexpected error 01551. ');
            }
        }

        $sessionMessage .= ' 90 day old messages will be deleted by admin. ';

        require VIEWS . DIRSEP . 'inbox.php';
    }
}