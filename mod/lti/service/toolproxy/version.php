<?php

/**
 * Version information for the ltiservice_toolproxy service.
 *
 * @package    ltiservice_toolproxy
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */


defined('LION_INTERNAL') || die();


$plugin->version   = 2014111000;
$plugin->requires  = 2014110400;
$plugin->component = 'ltiservice_toolproxy';
$plugin->dependencies = array(
    'ltiservice_profile' => 2014110400
);
