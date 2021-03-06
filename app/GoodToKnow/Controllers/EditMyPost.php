<?php

namespace GoodToKnow\Controllers;

class EditMyPost
{
    function page()
    {
        /**
         * This is the first in a series of routes aimed at editing a preexisting user's post.
         */

        /**
         * This route will present a form which asks which topic does the post exist in. Remember
         * first we need to have the user identify the post. So this first step will help.
         */

        require CONTROLLERINCLUDES . DIRSEP . 'get_topics_for_a_community.php';

        require VIEWS . DIRSEP . 'editmypost.php';
    }
}