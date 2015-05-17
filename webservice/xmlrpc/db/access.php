<?php



/**
 * XML-RPC server related capabilities
 *
 * @category   access
 * @package    webservice
 * @subpackage xmlrpc
 * @copyright  2015 Pooya Saeedi
 */

$capabilities = array(

    'webservice/xmlrpc:use' => array(
        'riskbitmask' => RISK_CONFIG | RISK_DATALOSS | RISK_SPAM | RISK_PERSONAL | RISK_XSS,
        'captype' => 'read', // in fact this may be considered read and write at the same time
        'contextlevel' => CONTEXT_COURSE, // the context level should be probably CONTEXT_MODULE
        'archetypes' => array(
        ),
    ),

);
