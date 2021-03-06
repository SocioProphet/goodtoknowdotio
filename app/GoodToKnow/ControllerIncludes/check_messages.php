<?php

use GoodToKnow\Models\MessageToUser;

global $messages_last_quantity;

global $messages_last_time;

if ($messages_last_time === null) {
    if ($db == 'not connected') {
        $db = db_connect($sessionMessage);

        if ($db === false) {
            $sessionMessage .= " Failed to connect to the database. ";
            $_SESSION['message'] = $sessionMessage;
            reset_feature_session_vars();
            redirect_to("/ax1/InfiniteLoopPrevent/page");
        }
    }

    $quantity = MessageToUser::user_message_quantity($db, $sessionMessage, $user_id);

    if ($quantity === false) {
        $sessionMessage .= " Failed to get quantity of messages. ";
        $_SESSION['message'] = $sessionMessage;
        reset_feature_session_vars();
        redirect_to("/ax1/InfiniteLoopPrevent/page");
    }

    $sessionMessage .= "<br><br>You have {$quantity} message(s).
    <img src=\"\mdollnaery.gif\" alt=\"Smiley face\" height=\"22px\"> ";

    $_SESSION['messages_last_quantity'] = $quantity;
    $_SESSION['messages_last_time'] = time();
} else {
    $time_since_last = time() - $messages_last_time;
    $time_since_last = $time_since_last / 60;

    if ($time_since_last > 17) {
        if ($db == 'not connected') {
            $db = db_connect($sessionMessage);

            if ($db === false) {
                $sessionMessage .= " Failed to connect to the database. ";
                $_SESSION['message'] = $sessionMessage;
                reset_feature_session_vars();
                redirect_to("/ax1/InfiniteLoopPrevent/page");
            }
        }

        $quantity = MessageToUser::user_message_quantity($db, $sessionMessage, $user_id);

        if ($quantity === false) {
            $sessionMessage .= " Failed to get quantity of messages. ";
            $_SESSION['message'] = $sessionMessage;
            reset_feature_session_vars();
            redirect_to("/ax1/InfiniteLoopPrevent/page");
        }

        $quantity_new = $quantity - $messages_last_quantity;

        if ($quantity > $messages_last_quantity) {
            $sessionMessage .= "<br><br>You have {$quantity} message(s). {$quantity_new} message(s) is/are new.
            <img src=\"\mdollnaery.gif\" alt=\"Smiley face\" height=\"22px\"> ";

            $_SESSION['messages_last_quantity'] = $quantity;
            $_SESSION['messages_last_time'] = time();
        }
    }
}