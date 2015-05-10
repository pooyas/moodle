<?php


/**
 * REST web service entry point. The authentication is done via username/password.
 *
 * @package    webservice
 * @subpackage rest
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * NO_DEBUG_DISPLAY - disable lion specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);

define('WS_SERVER', true);

require('../../config.php');
require_once("$CFG->dirroot/webservice/rest/locallib.php");

if (!webservice_protocol_is_enabled('rest')) {
    die;
}

$restformat = optional_param('lionwsrestformat', 'xml', PARAM_ALPHA);
//remove the alt from the request
if (isset($_REQUEST['lionwsrestformat'])) {
    unset($_REQUEST['lionwsrestformat']);
}
if (isset($_GET['lionwsrestformat'])) {
    unset($_GET['lionwsrestformat']);
}
if (isset($_POST['lionwsrestformat'])) {
    unset($_POST['lionwsrestformat']);
}

$server = new webservice_rest_server(WEBSERVICE_AUTHMETHOD_USERNAME);
$server->run();
die;


