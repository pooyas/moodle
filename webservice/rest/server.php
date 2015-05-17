<?php



/**
 * REST web service entry point. The authentication is done via tokens.
 *
 * @package    webservice
 * @subpackage rest
 * @copyright  2015 Pooya Saeedi
 */

/**
 * NO_DEBUG_DISPLAY - disable lion specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);

define('WS_SERVER', true);

require('../../config.php');
require_once("$CFG->dirroot/webservice/rest/locallib.php");

if (!webservice_protocol_is_enabled('rest')) {
    header("HTTP/1.0 403 Forbidden");
    debugging('The server died because the web services or the REST protocol are not enable',
        DEBUG_DEVELOPER);
    die;
}

$server = new webservice_rest_server(WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN);
$server->run();
die;

