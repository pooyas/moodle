<?php


/**
 * SOAP web service entry point. The authentication is done via username/password.
 *
 * @package    webservice
 * @subpackage soap
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * NO_DEBUG_DISPLAY - disable lion specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);

define('WS_SERVER', true);

// Make sure OPcache does not strip comments, we need them for Zend!
if (ini_get('opcache.enable') and strtolower(ini_get('opcache.enable')) !== 'off') {
    if (!ini_get('opcache.save_comments') or strtolower(ini_get('opcache.save_comments')) === 'off') {
        ini_set('opcache.enable', 0);
    } else {
        ini_set('opcache.load_comments', 1);
    }
}

require('../../config.php');
require_once("$CFG->dirroot/webservice/soap/locallib.php");

if (!webservice_protocol_is_enabled('soap')) {
    die;
}

$server = new webservice_soap_server(WEBSERVICE_AUTHMETHOD_USERNAME);
$server->run();
die;


