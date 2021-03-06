<?php

namespace GoodToKnow\ControllerHelpers;

/**
 * @param string $message
 * @param string $str01
 * @param string $str02
 * @return bool
 */
function is_password_asapair(string &$message, string &$str01, string &$str02): bool
{
    /**
     * First make sure it has proper syntax.
     */

    require_once CONTROLLERHELPERS . DIRSEP . 'is_password_syntactically.php';

    if (!is_password_syntactically($message, $str01)) {

        $message .= " The password's syntax is invalid. ";

        return false;
    }


    /**
     * Make sure the two strings match.
     */

    $are_equal = ($str01 === $str02);

    if (!$are_equal) {

        $message .= " Your two passwords don't match. ";

        return false;
    }

    return true;
}