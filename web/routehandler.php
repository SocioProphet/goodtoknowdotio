<?php
/**
 * Created by PhpStorm.
 * User: samehlabib
 * Date: 8/18/18
 * Time: 8:22 PM
 */

require(__DIR__ . '/../config.php');

define('DIRSEP', DIRECTORY_SEPARATOR);
define('WEB_DIR', PROJ_ROOT . DIRSEP . 'web');
define('VENDOR_DIR', PROJ_ROOT . DIRSEP . 'vendor');
define('MARKDOWN', DIRSEP . 'goodfiles' . DIRSEP . 'markdown');
define('STATIC', DIRSEP . 'goodfiles' . 'static');

/**
 * Here I can define constants for the location
 * of the directory for view includes and for
 * the files for view includes.
 */
define('VIEWS', PROJ_ROOT . DIRSEP . 'app' . DIRSEP . 'GoodToKnow' . DIRSEP . 'Views');
define('VIEWSINCLUDES', PROJ_ROOT . DIRSEP . 'app' . DIRSEP . 'GoodToKnow' . DIRSEP . 'ViewsIncludes');

define('TOP', VIEWSINCLUDES . DIRSEP . 'top.php');
define('BOTTOM', VIEWSINCLUDES . DIRSEP . 'bottom.php');
define('SESSIONMESSAGE', VIEWSINCLUDES . DIRSEP . 'sessionmessage.php');

/**
 * More require statements
 */
$path3 = VENDOR_DIR . DIRSEP . 'autoload.php';
$path4 = WEB_DIR . DIRSEP . 'functions.php';
require $path3;
require $path4;

// Define Stripe Keys
//if (ENVIRONMENT == 'development') {
//    $myStripePubKey = TESTSTRIPEPUB;
//    $myStripeSecKey = TESTSTRIPESEC;
//} elseif (ENVIRONMENT == 'production') {
//    $myStripePubKey = LIVESTRIPEPUB;
//    $myStripeSecKey = LIVESTRIPESEC;
//} else {
//    die('I do not know which environment I am in.');
//}

/**
 * Before we call the controller method
 * let us gather some knowledge from
 * the session and put it into variables
 * which have friendly names.
 */
session_start();

$sessionMessage = (isset($_SESSION['message'])) ? $_SESSION['message'] : '';

$user_id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;

$role = (isset($_SESSION['role'])) ? $_SESSION['role'] : '';

// The name of community which the user wants to see.
$community_name = (isset($_SESSION['community_name'])) ? $_SESSION['community_name'] : '';

// The names of communities the user belongs to.
$community_name_array = (isset($_SESSION['community_name_array'])) ? $_SESSION['community_name_array'] : [];

$community_id = (isset($_SESSION['community_id'])) ? $_SESSION['community_id'] : 0;

$topic_id = (isset($_SESSION['topic_id'])) ? $_SESSION['topic_id'] : 0;

$page_id = (isset($_SESSION['page_id'])) ? $_SESSION['page_id'] : 0;

$is_logged_in = (!empty($user_id)) ? true : false;

$is_admin = ($role === 'admin') ? true : false;


/**
 * Section Description:
 * HERE WE DETERMINE WHICH CONTROLLER
 *                   WHICH METHOD
 *                   WHAT PARAMETERS TO PASS TO THE METHOD
 * AND THEN WE CALL THIS METHOD GIVING IT THE PARAMETERS
 * WE DETERMINE ALL THIS BASED ON THE ROUTE SPECIFIED
 * BY THE HTTP REQUEST
 */

/**
 * An array of the segments supplied
 * by the user in the HTTP request
 */
$route_segments_array = [];

/**
 * $_SERVER['PATH_INFO']
 * If the URI portion of the URL starts with /# then the value of
 * $_SERVER['PATH_INFO'] will be everything that follows the /# portion of the URI.
 */

if (!empty($_SERVER['PATH_INFO'])) {
    $route = rtrim($_SERVER['PATH_INFO'], '/ ');
    $route = ltrim($route, '/');
    // The FILTER_SANITIZE_URL filter removes all illegal URL characters from a string.
    // This filter allows all letters, digits and $-_.+!*'(),{}|\\^~[]`"><#%;/?:@&=
    $route = filter_var($route, FILTER_SANITIZE_URL);
    $route_segments_array = explode('/', $route);
}

/*
 * Debug
 */
//var_dump($route_segments_array);
//die('End here');
// array(2) { [0]=> string(4) "Home" [1]=> string(4) "page" } End here


/**
 * Figure out which controller
 * and instantiate its object
 */

$controller_name = 'LoginForm';    // Default controller

if (!empty($route_segments_array[0])) {
    $file_path_to_controller = PROJ_ROOT . DIRSEP . 'app' . DIRSEP . 'GoodToKnow' . DIRSEP . 'Controllers' . DIRSEP .
        "{$route_segments_array[0]}.php";

    /**
     * Debug
     */
//    echo "The file path to controller is: " . $file_path_to_controller;
//    die(' period.');

    if (file_exists($file_path_to_controller)) {
        $controller_name = $route_segments_array[0];
        unset($route_segments_array[0]);
    }
}

$fully_qualified_controller_name = 'GoodToKnow\Controllers\\' . $controller_name;

$controller_object = new $fully_qualified_controller_name;

/**
 * Figure out which method
 * and call it
 */

$method_name = 'page';

if (!empty($route_segments_array[1])) {
    if (method_exists($controller_object, $route_segments_array[1])) {
        $method_name = $route_segments_array[1];
        unset($route_segments_array[1]);
    }
}

$parameters_array = [];

if (!empty($route_segments_array)) {
    $parameters_array = array_values($route_segments_array);
}

/**
 * Debug
 */
echo "<p>Controller name is: {$controller_name}</p>\n";
echo "<p>Method name is: {$method_name}</p>\n";
die('Stop');


call_user_func_array([$controller_object, $method_name], $parameters_array);
