<?php


/**
 * AMF web service entry point. The authentication is done via tokens.
 *
 * @package    webservice_amf
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
require_once("$CFG->dirroot/webservice/amf/locallib.php");

if (!webservice_protocol_is_enabled('amf')) {
    debugging('The server died because the web services or the AMF protocol are not enable',
        DEBUG_DEVELOPER);
    die;
}

$server = new webservice_amf_server(WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN);
$server->run();
die;

