<?php


/**
 * A script to serve files from web service client
 *
 * @package    core_webservice
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * AJAX_SCRIPT - exception will be converted into JSON
 */
define('AJAX_SCRIPT', true);

/**
 * NO_LION_COOKIES - we don't want any cookie
 */
define('NO_LION_COOKIES', true);


require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->dirroot . '/webservice/lib.php');

//authenticate the user
$token = required_param('token', PARAM_ALPHANUM);
$webservicelib = new webservice();
$authenticationinfo = $webservicelib->authenticate_user($token);

//check the service allows file download
$enabledfiledownload = (int) ($authenticationinfo['service']->downloadfiles);
if (empty($enabledfiledownload)) {
    throw new webservice_access_exception('Web service file downloading must be enabled in external service settings');
}

//finally we can serve the file :)
$relativepath = get_file_argument();
file_pluginfile($relativepath, 0);
