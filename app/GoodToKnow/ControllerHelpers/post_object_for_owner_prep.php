<?php

namespace GoodToKnow\ControllerHelpers;

use GoodToKnow\Models\Post;
use mysqli;

/**
 * @param string $field_name
 * @param mysqli $db
 * @param $user_id
 * @return object
 */
function post_object_for_owner_prep(string $field_name, mysqli $db, $user_id): object
{
    /**
     * Returns a Post object belonging to the user.
     * Also saves the post id in the session.
     */

    global $sessionMessage;

    require_once CONTROLLERHELPERS . DIRSEP . 'integer_form_field_prep.php';

    $chosen_post_id = integer_form_field_prep($field_name, 1, PHP_INT_MAX);


    $post_object = Post::find_by_id($db, $sessionMessage, $chosen_post_id);

    if (!$post_object) {

        breakout(' Error 011299. ');

    }

    if ($post_object->user_id != $user_id) {

        breakout(' You can\'t edit or delete this post. ');

    }


    $_SESSION['saved_int02'] = $chosen_post_id;


    return $post_object;
}