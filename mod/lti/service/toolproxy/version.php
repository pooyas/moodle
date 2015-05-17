<?php


/**
 * Version information for the ltiservice_toolproxy service.
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


$plugin->version   = 2014111000;
$plugin->requires  = 2014110400;
$plugin->component = 'ltiservice_toolproxy';
$plugin->dependencies = array(
    'ltiservice_profile' => 2014110400
);
