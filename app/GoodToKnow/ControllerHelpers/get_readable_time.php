<?php

namespace GoodToKnow\ControllerHelpers;

/**
 * @param $created
 * @return string
 */
function get_readable_time($created): string
{
    $created = (int)$created;

    $date = date('m/d/Y h:ia ', $created) . "<small>[" . date_default_timezone_get() . "]</small>";

    return $date;
}