<?php


/**
 * SOAP server related capabilities
 *
 * @package    webservice_soap
 * @category   access
 * @copyright  2009 Petr Skodak
 * 
 */

$capabilities = array(

    'webservice/soap:use' => array(
        'riskbitmask' => RISK_CONFIG | RISK_DATALOSS | RISK_SPAM | RISK_PERSONAL | RISK_XSS,
        'captype' => 'read', // in fact this may be considered read and write at the same time
        'contextlevel' => CONTEXT_COURSE, // the context level should be probably CONTEXT_MODULE
        'archetypes' => array(
        ),
    ),

);
